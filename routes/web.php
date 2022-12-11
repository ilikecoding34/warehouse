<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PictureController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomfieldController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Item;
use App\Models\User;
use App\Models\Quantity;
use Illuminate\Http\Request;

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
    return view('home');
});

Route::get('/webcam', function () {
    return view('webcam');
});

Route::get('/qrcode', [QrCodeController::class, 'index']);

Auth::routes();

Route::group(['middleware' => ['auth']], function() {
    Route::resource('items', ItemController::class);
    Route::resource('pictures', PictureController::class);
    Route::resource('types', TypeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('customfields', CustomfieldController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);

    //Egyedi útvonalak

    Route::get('/pictures/{id}/modal', [PictureController::class, 'modal'])->name('pictures.modal');

    Route::get('/pictures/restore/{id}', [PictureController::class, 'restore'])->name('pictures.restore');

    Route::post('/pictures/storetoitem/{id}', [PictureController::class, 'storetoitem'])->name('pictures.storetoitem');

    Route::post('/pictures/deletefromitem', [PictureController::class, 'deletefromitem'])->name('pictures.deletefromitem');

    Route::post('/webcamstore', [PictureController::class, 'webcamstore'])->name('webcam.capture');

    Route::post('/additemtype/{item}', [ItemController::class, 'addtype'])->name('items.addtype');

    Route::get('/items/{id}/modal', [ItemController::class, 'modal'])->name('items.modal');

    Route::get('/items/restore/{id}', [ItemController::class, 'restore'])->name('items.restore');

    Route::get('/categories/{id}/modal', [CategoryController::class, 'modal'])->name('categories.modal');

    Route::get('/categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');

    Route::get('/customfields/{id}/modal', [CustomfieldController::class, 'modal'])->name('customfields.modal');

    Route::get('/customfields/restore/{id}', [CustomfieldController::class, 'restore'])->name('customfields.restore');

});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
