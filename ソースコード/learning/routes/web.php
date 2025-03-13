<?php

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

//Route::get('/', function () {return view('welcome');});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/',App\Http\Controllers\StudyController::class)->name('study.index')->middleware('auth');;

Route::resource('blogs', App\Http\Controllers\BlogController::class)->middleware('auth'); 

Route::resource('todo_items', App\Http\Controllers\TodoItemController::class)->middleware('auth');

Route::resource('notes', App\Http\Controllers\NoteController::class)->middleware('auth');

Route::resource('categories', App\Http\Controllers\CategoryController::class)->middleware('auth');

Route::get('goals',[App\Http\Controllers\GoalController::class,'index'])->name('goals.index')->middleware('auth');;

Route::get('goals/long/create',[App\Http\Controllers\GoalController::class,'createLongGoal'])->name('goals.long.create')->middleware('auth');

Route::post('goals/long/create',[App\Http\Controllers\GoalController::class,'storeLongGoal'])->name('goals.long.store')->middleware('auth');

Route::get('goals/long/edit/{long_goal?}',[App\Http\Controllers\GoalController::class,'editLongGoal'])->name('goals.long.edit')->middleware('auth');

//PATCHにしたらとべた。PATCH使わないのか？？
Route::post('goals/long/edit/{long_goal?}',[App\Http\Controllers\GoalController::class,'updateLongGoal'])->name('goals.long.update')->middleware('auth');

Route::post('goals/long/destroy',[App\Http\Controllers\GoalController::class,'destroyLongGoal'])->name('goals.long.destroy')->middleware('auth');

Route::get('goals/short/create',[App\Http\Controllers\GoalController::class,'createShortGoal'])->name('goals.short.create')->middleware('auth');

Route::post('goals/short/create',[App\Http\Controllers\GoalController::class,'storeShortGoal'])->name('goals.short.store')->middleware('auth');

Route::get('goals/short/edit/{short_goal?}',[App\Http\Controllers\GoalController::class,'editShortGoal'])->name('goals.short.edit')->middleware('auth');

Route::post('goals/short/edit/{short_goal?}',[App\Http\Controllers\GoalController::class,'updateShortGoal'])->name('goals.short.update')->middleware('auth');

Route::post('goals/short/destroy',[App\Http\Controllers\GoalController::class,'destroyShortGoal'])->name('goals.short.destroy')->middleware('auth');

Route::get('users/edit/{user?}',[App\Http\Controllers\UserController::class,'editUser'])->name('users.edit')->middleware('auth');

Route::post('users/edit/{user?}',[App\Http\Controllers\UserController::class,'updateUser'])->name('users.update')->middleware('auth');


