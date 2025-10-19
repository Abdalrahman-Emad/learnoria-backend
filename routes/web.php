<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

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
