<?php

namespace App\Console\Commands;

use App\Models\BookEditor;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckInactiveEditors extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'editors:check-inactive {--days=7 : Number of days to consider editor inactive}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for inactive editors and notify admin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $cutoffDate = Carbon::now()->subDays($days);

        $this->info("Checking for editors inactive for more than {$days} days...");

        // Find approved editors who haven't uploaded files and are inactive
        $inactiveEditors = BookEditor::with(['book', 'user'])
            ->where('status', BookEditor::STATUS_APPROVED)
            ->where(function ($query) {
                $query->whereNull('file_path')
                    ->orWhereNull('file_turnitin');
            })
            ->where('updated_at', '<', $cutoffDate)
            ->get();

        if ($inactiveEditors->isEmpty()) {
            $this->info('No inactive editors found.');

            return Command::SUCCESS;
        }

        $this->warn("Found {$inactiveEditors->count()} inactive editor(s):");

        foreach ($inactiveEditors as $editor) {
            $this->line("- {$editor->user->full_name} (Book: {$editor->book->title}) - Last updated: {$editor->updated_at->diffForHumans()}");
        }

        // Option to automatically reject inactive editors
        if ($this->confirm('Do you want to automatically reject these inactive editors?')) {
            $count = $inactiveEditors->count();

            foreach ($inactiveEditors as $editor) {
                $editor->update([
                    'status' => BookEditor::STATUS_REJECTED,
                    'notes' => 'Automatically rejected due to inactivity ('.$days.' days)',
                ]);
            }

            $this->info("Successfully rejected {$count} inactive editor(s).");
        }

        return Command::SUCCESS;
    }
}
