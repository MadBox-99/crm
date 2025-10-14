<?php

declare(strict_types=1);

use App\Http\Controllers\ChatDemoController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

Route::get('/', fn (): Factory|View => view('welcome'));

// Chat demo route
Route::get('/chat-demo', [ChatDemoController::class, 'index'])->name('chat.demo');

// Complaint submission route
Route::get('/complaints/submit', fn (): Factory|View => view('complaint-form'))->name('complaints.submit');
