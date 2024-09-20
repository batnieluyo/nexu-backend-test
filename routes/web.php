<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => ['version' => '1.0.0'])->withoutMiddleware(['auth', 'web']);

require __DIR__.'/api.php';
