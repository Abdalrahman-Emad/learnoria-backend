<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/db-info', function () {
    return [
        'database' => DB::select("SELECT database() as db")[0]->db,
        'host' => config('database.connections.mysql.host'),
        'port' => config('database.connections.mysql.port'),
        'username' => config('database.connections.mysql.username'),
    ];
});

Route::get('/test-mail', function () {
    Mail::raw('This is a test email from Learnoria', function ($message) {
        $message->to('abdalrahmanemad48@gmail.com')
                ->subject('Test Email from Learnoria');
    });

    return 'Mail sent (or queued) - check logs';
});
