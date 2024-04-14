<?php

use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;

Route::get('/', function () {
    return view('index');
});

// Login Routes
Route::get('/login', [LoginController::class, "loadLogin"])->name("login");
Route::post('/login/submit', [LoginController::class, "login"]);

// Mail Routes
Route::get('/inbox', [MailController::class, "loadInbox"])->name("inbox");
Route::get('/sent', [MailController::class, "loadOutbox"])->name("outbox");
Route::get('/compose', [MailController::class, "loadCompose"])->name("compose");
Route::get('/inboundMails', [MailController::class, "getInboundEmails"]);
Route::get('/mail/{mailId}', [MailController::class, "loadMail"])->name("read");