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

// Bisa dilihat tanpa login
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

// Autentifikasi user
Auth::routes();
Route::get('/koleksi-buku', 'HomeController@index')->name('home');
Route::post('/koleksi-buku-filter', 'HomeController@index_filter');
Route::post('/koleksi-buku-kategori-filter', 'HomeController@index_filter_cathegory');
Route::get('/koleksi-buku-kategori/{ddc}', 'HomeController@book_cathegory');
Route::get('/', 'BiblioController@front_index')->name('index');
Route::get('/detail-buku/{id}','BiblioController@front_detailBiblio')->name('detail-buku');
Route::get('/buku-baru','BiblioController@front_newBook');
Route::post('/rekomendasi-buku', 'BiblioController@topsis');
Route::get('/form-rekomendasi', 'BiblioController@formTopsis');


Route::middleware(['auth'])->group(function(){
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
    Route::get('daftar-penghapusan-buku','ItemController@deletion');
    Route::get('/cetak-laporan-penghapusan','ItemController@printDeleteReport')->name('daftar-penghapusan-buku.printDeleteReport');
    Route::get('/daftar-pesanan','BiblioController@bookingList');

    //User Akses
    Route::get('/pesan-buku/{id}','BiblioController@formBooking');
    Route::post('/pesanan-catat', 'BiblioController@addBooking');
    Route::get('/daftar-pesanan/{id}','BiblioController@myBooking');
    Route::post('/hapus-pesanan','BiblioController@deleteMyBooking');

    //Class
    //Admin Akses
    Route::resource('daftar-kelas', 'ClassesController');
    Route::post('/daftar-kelas/getEditForm','ClassesController@getEditForm')->name('daftar-kelas.getEditForm');
    Route::post('daftar-kelas/updateData','ClassesController@updateData')->name('daftar-kelas.updateData');

    //Borrow + borrow transaction
    //Admin Akses
    Route::resource('daftar-peminjaman', 'BorrowController');
    Route::post('/grafik-pinjaman-filter', 'BorrowController@graphicYear');
    Route::get('/sirkulasi-buku','BorrowController@listUser');
    Route::post('/daftar-peminjaman/getDetail','BorrowController@getDetail')->name('daftar-peminjaman.getDetail');
    Route::get('/grafik-peminjaman','BorrowController@graphic');
    Route::get('sirkulasi-detail/{id}','BorrowController@detailCirculation');
    Route::post('/return','BorrowController@bookReturn');
    Route::post('/extension','BorrowController@bookExtension');
    Route::get('/tambah-sirkulasi-buku/{id}','BorrowController@detailAddCirculation');

    // User Akses
    Route::get('/daftar-pinjaman/{id}', 'BorrowController@myBorrow');
    Route::post('/extension-user','BorrowController@bookExtensionUser');

    // Visit
    // Admin
    Route::resource('kunjungan', 'VisitController');
    Route::get('/grafik-pengunjung','VisitController@graphic');
    Route::post('/grafik-pengunjung-filter','VisitController@graphicYear');
    Route::post('/kunjungan/getAddForm','VisitController@getAddForm')->name('kunjungan.getAddForm');
    Route::post('/tambah-kunjungan','VisitController@addVisit')->name('kunjungan.addVisit');
    Route::get('/laporan-kunjungan','VisitController@listVisit');
    Route::get('/cetak-laporan-kunjungan','VisitController@printVisitReport');
    // User
    Route::get('/form-masuk','VisitController@getVisitForm');
    Route::post('/masuk-perpustakaan-catat','VisitController@visitUserAdd');

    // User + suggestion
    Route::get('daftar-murid', 'UserController@student');
    Route::get('daftar-guru', 'UserController@teacher');
    Route::resource('daftar-usulan-buku', 'SuggestionController');
    Route::post('/daftar-usulan-buku/getEditForm','SuggestionController@getEditForm')->name('daftar-usulan-buku.getEditForm');
    Route::post('daftar-usulan-buku/updateData','SuggestionController@updateData')->name('daftar-usulan-buku.updateData');
    Route::post('daftar-usulan-buku/deleteDataAdmin','SuggestionController@deleteDataAdmin')->name('suggestions.deleteDataAdmin');
    Route::get('/cetak-usulan','SuggestionController@printSuggestionReport');
    Route::get('/ubah-data-pengguna/{id}', 'UserController@getEditForm');
    Route::post('/aksi-ubah-data', 'UserController@editDataUserAdmin');

    // User akses
    Route::get('/profil/{id}', 'UserController@getProfileUser');
    Route::post('/editPassword', 'UserController@editPasswordUser');

    Route::get('/form-usulan','SuggestionController@getSugesstionForm');
    Route::get('/usulan-saya/{id}','SuggestionController@mySuggestion');
    Route::post('/usulan-catat','SuggestionController@addSuggestionUser');
    Route::get('/daftar-usulan', 'SuggestionController@front_index');
    Route::get('/ubah-usulan/{id}', 'SuggestionController@getEditFormUser');
    Route::post('/ubah-usulan-catat', 'SuggestionController@editSuggestion');
    Route::get('/hapus-usulan/{id}', 'SuggestionController@deleteSuggestionUser');
});
