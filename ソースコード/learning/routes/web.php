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

//TOP画面
Route::get('/',App\Http\Controllers\StudyController::class)->name('study.index')->middleware('auth');;

//ブログの一覧・登録・表示・更新・削除画面
Route::resource('blogs', App\Http\Controllers\BlogController::class)->middleware('auth'); 

//TODO項目の一覧・登録・表示・更新・削除画面
Route::resource('todo_items', App\Http\Controllers\TodoItemController::class)->middleware('auth');

//ノートのの一覧・登録・表示・更新・削除画面
Route::resource('notes', App\Http\Controllers\NoteController::class)->middleware('auth');

//カテゴリーの一覧・登録・表示・更新・削除画面
Route::resource('categories', App\Http\Controllers\CategoryController::class)->middleware('auth');

//長期・短期目標の一覧表示画面
Route::get('goals',[App\Http\Controllers\GoalController::class,'index'])->name('goals.index')->middleware('auth');;

//長期目標登録画面
Route::get('goals/long/create',[App\Http\Controllers\GoalController::class,'createLongGoal'])->name('goals.long.create')->middleware('auth');

//長期目標登録処理
Route::post('goals/long/create',[App\Http\Controllers\GoalController::class,'storeLongGoal'])->name('goals.long.store')->middleware('auth');

//長期目標更新画面
Route::get('goals/long/edit/{long_goal?}',[App\Http\Controllers\GoalController::class,'editLongGoal'])->name('goals.long.edit')->middleware('auth');

//長期目標更新処理
Route::post('goals/long/edit/{long_goal?}',[App\Http\Controllers\GoalController::class,'updateLongGoal'])->name('goals.long.update')->middleware('auth');

//長期目標削除画面
Route::post('goals/long/destroy',[App\Http\Controllers\GoalController::class,'destroyLongGoal'])->name('goals.long.destroy')->middleware('auth');

//短期目標登録画面
Route::get('goals/short/create',[App\Http\Controllers\GoalController::class,'createShortGoal'])->name('goals.short.create')->middleware('auth');

//短期目標登録処理
Route::post('goals/short/create',[App\Http\Controllers\GoalController::class,'storeShortGoal'])->name('goals.short.store')->middleware('auth');

//短期目標更新画面
Route::get('goals/short/edit/{short_goal?}',[App\Http\Controllers\GoalController::class,'editShortGoal'])->name('goals.short.edit')->middleware('auth');

//短期目標更新処理
Route::post('goals/short/edit/{short_goal?}',[App\Http\Controllers\GoalController::class,'updateShortGoal'])->name('goals.short.update')->middleware('auth');

//短期目標削除処理
Route::post('goals/short/destroy',[App\Http\Controllers\GoalController::class,'destroyShortGoal'])->name('goals.short.destroy')->middleware('auth');

//ユーザー情報更新画面
Route::get('users/edit/{user?}',[App\Http\Controllers\UserController::class,'editUser'])->name('users.edit')->middleware('auth');

//ユーザー情報更新処理
Route::post('users/edit/{user?}',[App\Http\Controllers\UserController::class,'updateUser'])->name('users.update')->middleware('auth');


