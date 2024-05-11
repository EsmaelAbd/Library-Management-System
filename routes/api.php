<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookBorrowedController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['logrequests', 'checkuserauthorization', 'handletransactions'])->group(function () {
});
Route::post('users', [UserController::class, 'store']);

Route::controller(UserController::class)->group(function () {
    Route::post('login', 'login')->middleware('log');
});

Route::post('send', [BookBorrowedController::class, 'send']);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('/books', BookController::class);

    Route::get('/books/search/{name}', [BookController::class, 'search']);
});


Route::post('/users/register', [UserController::class, 'register']);
Route::post('/users/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/profile', [UserController::class, 'profile']);
    Route::put('/users/profile', [UserController::class, 'updateProfile']);
});

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{id}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);
});


Route::get('/authors', [AuthorController::class, 'index']);
Route::get('/authors/{id}', [AuthorController::class, 'show']);
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/authors', [AuthorController::class, 'store']);
    Route::put('/authors/{id}', [AuthorController::class, 'update']);
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy']);
});


Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/reviews/books/{book_id}', [ReviewController::class, 'storeForBook']);
Route::post('/reviews/authors/{author_id}', [ReviewController::class, 'storeForAuthor']);
Route::middleware(['auth:sanctum'])->put('/reviews/{id}', [ReviewController::class, 'update']);
Route::middleware(['auth:sanctum'])->delete('/reviews/{id}', [ReviewController::class, 'destroy']);


Route::middleware(['auth:sanctum'])->get('/notifications', [NotificationController::class, 'index']);
Route::middleware(['auth:sanctum'])->put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
