<?php


use App\Http\Controllers\ShortURLController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ShortURLController::class, 'index']);
Route::get('/url/{shortId}', [ShortURLController::class, 'redirectionShortIdToOriginalUrl']);
Route::post('/shorten', [ShortURLController::class, 'shorten'])->name('shorten.url');
