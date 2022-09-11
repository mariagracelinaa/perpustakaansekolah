<?php

use Illuminate\Support\Facades\Route;

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

// Publisher
Route::resource('daftar-penerbit', 'PublisherController');
Route::post('/daftar-penerbit/getEditForm','PublisherController@getEditForm')->name('daftar-penerbit.getEditForm');
Route::post('daftar-penerbit/updateData','PublisherController@updateData')->name('daftar-penerbit.updateData');


// Author
Route::resource('daftar-penulis', 'AuthorController');
Route::post('/daftar-penulis/getEditForm','AuthorController@getEditForm')->name('daftar-penulis.getEditForm');
Route::post('daftar-penulis/updateData','AuthorController@updateData')->name('daftar-penulis.updateData');


// Biblio + Item
Route::resource('daftar-buku', 'BiblioController');
// Route::get('buku-item', 'ItemController@index');
Route::get('daftar-buku-detail/{id}','BiblioController@detailBiblio');
