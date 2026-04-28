<?php

namespace App\Console\Commands;

use App\Models\BookAuthor;
use App\Models\Module;
use Illuminate\Console\Command;

class SyncBookAuthorsFromModules extends Command
{
    protected $signature = 'book-authors:sync-from-modules {--dry-run} {--chunk=500} {--book=} {--module=}';

    protected $description = 'Create missing book_authors rows for modules that already have user_id';

    public function handle(): int
    {
        $dryRun = (bool) $this->option('dry-run');
        $chunkSize = (int) $this->option('chunk');
        $bookId = $this->option('book');
        $moduleId = $this->option('module');

        $query = Module::query()
            ->select(['id', 'book_id', 'user_id'])
            ->whereNotNull('user_id');

        if (is_string($bookId) && $bookId !== '') {
            $query->where('book_id', $bookId);
        }

        if (is_string($moduleId) && $moduleId !== '') {
            $query->where('id', $moduleId);
        }

        $processed = 0;
        $created = 0;
        $restored = 0;
        $exists = 0;

        foreach ($query->lazyById($chunkSize, 'id') as $module) {
            $processed++;

            $existing = BookAuthor::withTrashed()
                ->where('module_id', $module->id)
                ->where('user_id', $module->user_id)
                ->first();

            if ($existing) {
                if (method_exists($existing, 'trashed') && $existing->trashed()) {
                    $restored++;
                    if (! $dryRun) {
                        $existing->restore();
                    }
                } else {
                    $exists++;
                }

                continue;
            }

            $created++;
            if (! $dryRun) {
                BookAuthor::create([
                    'module_id' => $module->id,
                    'book_id' => $module->book_id,
                    'user_id' => $module->user_id,
                ]);
            }
        }

        $this->info('Sync finished.');
        $this->line('dry_run: '.($dryRun ? 'yes' : 'no'));
        $this->line('processed: '.$processed);
        $this->line('created: '.$created);
        $this->line('restored: '.$restored);
        $this->line('already_exists: '.$exists);

        return Command::SUCCESS;
    }
}
