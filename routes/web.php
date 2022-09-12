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
// Admin Akses
Route::resource('daftar-penerbit', 'PublisherController');
Route::post('/daftar-penerbit/getEditForm','PublisherController@getEditForm')->name('daftar-penerbit.getEditForm');
Route::post('daftar-penerbit/updateData','PublisherController@updateData')->name('daftar-penerbit.updateData');
//User Akses

// Author
//Admin Akses
Route::resource('daftar-penulis', 'AuthorController');
Route::post('/daftar-penulis/getEditForm','AuthorController@getEditForm')->name('daftar-penulis.getEditForm');
Route::post('daftar-penulis/updateData','AuthorController@updateData')->name('daftar-penulis.updateData');
//User Akses

// Biblio + Item
//Admin Akses
Route::resource('daftar-buku', 'BiblioController');
Route::get('daftar-buku-detail/{id}','BiblioController@detailBiblio');
//User Akses

//Classroom
//Admin Akses
Route::resource('daftar-kelas', 'ClassroomController');
Route::post('/daftar-kelas/getEditForm','ClassroomController@getEditForm')->name('daftar-kelas.getEditForm');
Route::post('daftar-kelas/updateData','ClassroomController@updateData')->name('daftar-kelas.updateData');


