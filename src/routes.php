<?php

use Illuminate\Support\Facades\Route;
use OnkaarGujarr\Library\Http\Controllers\LibraryController;

Route::get('/getAllLibrary', [LibraryController::class, 'getAllLibrary']);
Route::post('/{article_id}/saveToLibrary', [LibraryController::class, 'saveToLibrary']);
Route::delete('/{article_id}/removeFromLibrary', [LibraryController::class, 'removeFromLibrary']);