<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotManController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/botmanWidget', function () {
    return view('botmanWidget');
});

Route::match(['get', 'post'], '/botman', [BotManController::class,'handle']);
// Route::match(['get', 'post'], '/botman', 'BotManController@handle');
//some notes here
//I have made some chages in the vender botman also to keep in mind video:https://www.youtube.com/watch?v=F8mwFXovJUE&t=3s