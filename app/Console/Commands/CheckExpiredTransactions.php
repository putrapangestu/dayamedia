<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transactions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and handle expired transactions';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking expired transactions...');

        $now = Carbon::now();

        // Send payment reminders
        $expiredTransactions = Transaction::where('status', 'pending')
            // ->where('expired_at', '<=', $now)
            // ->where('expired_at', '>', $now)
            // ->whereNull('reminder_sent_at')
            ->whereNull('payment_proof')
            ->where('expired_at', '<=', $now)
            ->whereNotNull('expired_at')
            ->get();

        foreach ($expiredTransactions as $transaction) {
            $transaction->update(['status' => 'expired']);
            $this->line("Expired transaction: {$transaction->code}");
        }

        $this->info("Expired {$expiredTransactions->count()} transactions.");

        return Command::SUCCESS;
    }
}
