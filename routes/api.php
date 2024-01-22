<?php

use App\Http\Controllers\QnaBoardController;
use App\Http\Controllers\UsersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/login', [UsersController::class, 'login']);

Route::get('/board/list/{page}', [QnaBoardController::class, 'getLists']);
Route::get('/board/view/{idx}', [QnaBoardController::class, 'show']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/board/create', [QnaBoardController::class, 'create']);
    Route::post('/board/reply/create', [QnaBoardController::class, 'replyCreate']);
    Route::put('/board/reply/choice', [QnaBoardController::class, 'setReplyChoice']);
    Route::delete('/board/reply/delete/{idx}', [QnaBoardController::class, 'replyDelete']);
//    Route::get('/board/view/{idx}', [QnaBoardController::class, 'show']);
});
