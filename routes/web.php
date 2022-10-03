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
Route::resource('daftar-item', 'ItemController');
Route::get('daftar-buku-detail/{id}','BiblioController@detailBiblio')->name('daftar-buku-detail');
Route::post('/daftar-buku/getEditForm', 'BiblioController@getEditForm')->name('daftar-buku.getEditForm');
Route::post('daftar-buku/updateData','BiblioController@updateData')->name('daftar-buku.updateData');
Route::post('/daftar-item/getEditForm', 'ItemController@getEditForm')->name('daftar-item.getEditForm');
Route::post('daftar-item/updateData','ItemController@updateData')->name('daftar-item.updateData');
Route::post('daftar-item/getDeleteForm','ItemController@getDeleteForm')->name('daftar-item.getDeleteForm');
Route::post('daftar-item/deleteData','ItemController@deleteData')->name('daftar-item.deleteData');
Route::get('daftar-penghapusan-buku','BiblioController@deletion');
Route::get('/cetak-laporan-penghapusan','BiblioController@printDeleteReport')->name('daftar-penghapusan-buku.printDeleteReport');
Route::get('/daftar-pesanan','BiblioController@bookingList');

//User Akses

//Class
//Admin Akses
Route::resource('daftar-kelas', 'ClassesController');
Route::post('/daftar-kelas/getEditForm','ClassesController@getEditForm')->name('daftar-kelas.getEditForm');
Route::post('daftar-kelas/updateData','ClassesController@updateData')->name('daftar-kelas.updateData');

//Borrow + borrow transaction
//Admin Akses
Route::resource('daftar-peminjaman', 'BorrowController');
// Route::post('daftar-peminjaman-filter', 'BorrowController@filter');
Route::get('/sirkulasi-buku','BorrowController@listUser');
Route::post('/daftar-peminjaman/getDetail','BorrowController@getDetail')->name('daftar-peminjaman.getDetail');
Route::get('/grafik-peminjaman','BorrowController@graphic');
Route::get('sirkulasi-detail/{id}','BorrowController@detailCirculation');
Route::post('/return','BorrowController@bookReturn');

// Visit
Route::resource('kunjungan', 'VisitController');
Route::get('/grafik-pengunjung','VisitController@graphic');
Route::post('/kunjungan/getAddForm','VisitController@getAddForm')->name('kunjungan.getAddForm');
Route::post('/tambah-kunjungan','VisitController@addVisit')->name('kunjungan.addVisit');
Route::get('/laporan-kunjungan','VisitController@listVisit');
Route::get('/cetak-laporan-kunjungan','VisitController@printVisitReport');

// Student + Teacher + suggestion
Route::resource('daftar-murid', 'StudentController');
Route::resource('daftar-guru', 'TeacherController');
Route::resource('daftar-usulan-buku', 'SuggestionController');
Route::post('/daftar-usulan-buku/getEditForm','SuggestionController@getEditForm')->name('daftar-usulan-buku.getEditForm');
Route::post('daftar-usulan-buku/updateData','SuggestionController@updateData')->name('daftar-usulan-buku.updateData');
Route::post('daftar-usulan-buku/deleteDataAdmin','SuggestionController@deleteDataAdmin')->name('suggestions.deleteDataAdmin');
Route::get('/cetak-usulan','SuggestionController@printSuggestionReport');


