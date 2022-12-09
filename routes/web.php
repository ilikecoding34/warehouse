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

Route::get('/quan/{par}', function ($par) {
    $maxids = Quantity::groupBy('item_id')->get(DB::raw('MAX(id) as id'))->pluck('id');
    $itemsabovevalue = Quantity::whereIn('id', $maxids)->where('value', '>', $par)->pluck('item_id');
    $items = Item::whereIn('id', function($query) use($par){
        $query->select('item_id')->from('quantities')->whereIn('id', function($query) use($par){
            $query->select(DB::raw('MAX(id) as id'))->from('quantities')->groupBy('item_id');
        })->where('value', '>', $par);
    })->get();
    return $items;
    $items = DB::select(DB::raw('SELECT items.*, tmp.value FROM items INNER JOIN (SELECT * FROM quantities where id in (SELECT MAX(id) as id FROM `quantities` GROUP by item_id) and value > '.$par.') as tmp ON items.id=tmp.item_id'));

    return $items;
});

Route::get('/qrcode', [QrCodeController::class, 'index']);

Auth::routes();

//Route::group(['middleware' => ['auth']], function() {
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

    Route::post('/additemtype/{item}', [ItemController::class, 'addtype'])->name('items.addtype');

    Route::get('/items/{id}/modal', [ItemController::class, 'modal'])->name('items.modal');

    Route::get('/items/restore/{id}', [ItemController::class, 'restore'])->name('items.restore');

    Route::get('/categories/{id}/modal', [CategoryController::class, 'modal'])->name('categories.modal');

    Route::get('/categories/restore/{id}', [CategoryController::class, 'restore'])->name('categories.restore');

    Route::get('/customfields/{id}/modal', [CustomfieldController::class, 'modal'])->name('customfields.modal');

    Route::get('/customfields/restore/{id}', [CustomfieldController::class, 'restore'])->name('customfields.restore');

//});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
