<?php

namespace App\Console\Commands;

use App\Models\Module;
use Illuminate\Console\Command;

class CheckModuleDeadlines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:check-deadlines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check module deadlines and update overdue status';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking module deadlines...');

        // Update modules that are overdue
        $overdueModules = Module::where('is_overdue', false)
            ->where(function ($query) {
                $query->where(function ($q) {
                    // Check for deadline_date type
                    $q->where('deadline_type', 'date')
                        ->whereNotNull('deadline_date')
                        ->where('deadline_date', '<', now());
                })->orWhere(function ($q) {
                    // Check for days type (calculate from created_at + days)
                    $q->where('deadline_type', 'days')
                        ->whereNotNull('days')
                        ->whereRaw('DATE_ADD(created_at, INTERVAL days DAY) < ?', [now()]);
                });
            })
            ->update(['is_overdue' => true]);

        $this->info("Updated {$overdueModules} overdue modules.");

        // Update modules that are no longer overdue
        $activeModules = Module::where('is_overdue', true)
            ->where(function ($query) {
                $query->where(function ($q) {
                    // Check for deadline_date type
                    $q->where('deadline_type', 'date')
                        ->whereNotNull('deadline_date')
                        ->where('deadline_date', '>=', now());
                })->orWhere(function ($q) {
                    // Check for days type (calculate from created_at + days)
                    $q->where('deadline_type', 'days')
                        ->whereNotNull('days')
                        ->whereRaw('DATE_ADD(created_at, INTERVAL days DAY) >= ?', [now()]);
                });
            })
            ->update(['is_overdue' => false]);

        $this->info("Updated {$activeModules} active modules.");

        return Command::SUCCESS;
    }
}
