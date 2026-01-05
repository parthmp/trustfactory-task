<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/**
 * every fifteen minutes it will check for stocks that are low and send an email to dummy admin
 */
Schedule::command('stock:notify-low')->everyFifteenMinutes();

Schedule::command('report:daily-sales')->dailyAt('23:59')->withoutOverlapping();