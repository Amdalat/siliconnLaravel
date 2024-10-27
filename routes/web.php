<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/home', function () {
//     return view('home');
// });

// Route::get('/home', [HomeController::class, "landingPage"]) -> name('landing.page');
// Route::get('/landing-page', [HomeController::class, "flip"]) -> name('flip');
// Route::get('/user/{username}/{id}', [HomeController::class, "user"]) -> name('user');

Route::get('/', [PostController::class, "index"]) -> name('home');
Route::get('/create-post', [PostController::class, "createPost"]) -> name('create.post');
// Route::get('/create-post', [PostController::class, "createPost"]) -> name('create.post')->middleware('auth');
// Route::put('/update-post/{id}', [PostController::class, "updatePost"]) -> name('update.post');


// Auth::routes();

Route::get('/home', [App\Http\Controllers\PostController::class, 'index'])->name('all.posts');

Route::post('/process-post', [PostController::class, "processPost"]) -> name('process.post');
Route::get('/single-post/{id}', [PostController::class, "singlePost"]) -> name('single.post');
Route::get('/edit-post/{id}', [PostController::class, "editPost"]) -> name('edit.post');
Route::post('/update-post/{id}', [PostController::class, "updatePost"]) -> name('update.post');
Route::delete('/delete-post/{id}', [PostController::class, "deletePost"]) -> name('delete.post');
Route::post('/comment/{id}', [PostController::class, "comment"]) -> name('comment');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
