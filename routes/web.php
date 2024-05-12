<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Users\UserIndex;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/users', UserIndex::class)->name('users.index');
});
