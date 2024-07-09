<?php

use App\Models\RegisterLink;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $twoDaysAgo = Carbon::now()->subDays(2);
    RegisterLink::where('created_at', '<', $twoDaysAgo)
        ->delete();
})->cron('0 0 */2 * *'); // every two days

//Schedule::call(function () {
//    send notification to vk
//})->everyTenMinutes();
