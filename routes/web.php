<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/qrcode', [QrCodeController::class, 'index']);

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::resource('items', ItemController::class);
    Route::resource('pictures', PictureController::class);
    Route::resource('types', TypeController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
        
    //Egyedi útvonalak

    Route::get('/pictures/{id}/modal', [PictureController::class, 'modal'])->name('pictures.modal');

    Route::get('/pictures/restore/{id}', [PictureController::class, 'restore'])->name('pictures.restore');

    Route::post('/additemtype/{item}', [ItemController::class, 'addtype'])->name('items.addtype');

    Route::get('/items/{id}/modal', [ItemController::class, 'modal'])->name('items.modal');

    Route::get('/items/restore/{id}', [ItemController::class, 'restore'])->name('items.restore');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
