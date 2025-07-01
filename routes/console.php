<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// === SCHEDULED TASKS FOR THE AUCTION PLATFORM ===

// This command runs every minute to automatically close auctions that have ended.
Schedule::command('auctions:close')->everyMinute();

// This command runs once daily at 9:00 AM to send "ending soon" reminders.
Schedule::command('auctions:notify-ending-soon')->dailyAt('09:00'); // <-- THIS IS THE NEW LINE

// ==================================================