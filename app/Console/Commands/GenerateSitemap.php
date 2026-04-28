<?php

namespace App\Console\Commands;

use App\Services\SitemapService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--path=sitemap.xml}';

    protected $description = 'Generate sitemap.xml into the public directory';

    public function handle(SitemapService $sitemapService): int
    {
        ini_set('memory_limit', '1024M'); // Increase memory limit for sitemap generation
        
        $sitemapService->writeToFile(public_path('sitemap.xml'));

        return Command::SUCCESS;
    }
}
