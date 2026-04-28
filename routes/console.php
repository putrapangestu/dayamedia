<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('app:update-affiliate-levels')->monthly();
Schedule::command('modules:check-deadlines')->daily();
Schedule::command('editors:check-inactive')->weekly();
Schedule::command('transactions:check-expired')->everyFiveMinutes();
Schedule::command('sitemap:generate')->daily()->at('00:30')->withoutOverlapping();
