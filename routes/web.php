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

// Author
Route::resource('daftar-penulis', 'AuthorController');

// Biblio + Item
Route::resource('daftar-buku', 'BiblioController');
// Route::get('buku-item', 'ItemController@index');
Route::get('daftar-buku-detail/{id}','BiblioController@detailBiblio');
