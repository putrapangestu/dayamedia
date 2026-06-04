<?php

namespace App\Console\Commands;

use App\Models\AffiliateLevel;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UpdateAffiliateLevels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-affiliate-levels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting affiliate level update process...');
        Log::info('Starting affiliate level update process...');

        $users = User::all();
        $affiliateLevels = AffiliateLevel::orderBy('min_earning', 'desc')->get();
        $lastMonth = Carbon::now()->subMonth();

        foreach ($users as $user) {
            $totalCommission = Transaction::where(function ($query) use ($user) {
                $query->whereHas('details.book.modules', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                    ->orWhereHas('user', function ($q) use ($user) {
                        $q->where('id', $user->id)
                            ->where('use_referral_code', $user->referral_code);
                    });
            })
                ->whereMonth('updated_at', $lastMonth->month)
                ->whereYear('updated_at', $lastMonth->year)
                ->sum('total_price');

            $newAffiliateLevel = null;
            foreach ($affiliateLevels as $level) {
                if ($totalCommission >= $level->min_earning) {
                    $newAffiliateLevel = $level;
                    break;
                }
            }

            if ($newAffiliateLevel && $user->affiliate_level_id !== $newAffiliateLevel->id) {
                $user->affiliate_level_id = $newAffiliateLevel->id;
                $user->save();
                $this->info("User {$user->full_name} has been updated to affiliate level {$newAffiliateLevel?->name}.");
                Log::info("User {$user->full_name} (ID: {$user->id}) has been updated to affiliate level {$newAffiliateLevel?->name} (ID: {$newAffiliateLevel->id}).");
            }
        }

        $this->info('Affiliate level update process finished.');
        Log::info('Affiliate level update process finished.');
    }
}
