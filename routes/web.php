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
// Tampilkan homepage web
Route::get('/', 'BiblioController@front_index')->name('index');
// Tampilkan koleksi buku tanpa login
Route::get('/koleksi-buku', 'HomeController@index')->name('home');
// Tampilkan koleksi buku tanpa login -> Habis di filter
Route::post('/koleksi-buku-filter', 'HomeController@index_filter');

// Route::post('/koleksi-buku-kategori-filter', 'HomeController@index_filter_category');
// Tampilkan buku sesuai kategori DDC 000-900 di index tanpa login
Route::get('/koleksi-buku-kategori/{ddc}', 'HomeController@book_category');
// Tampilkan detail buku user
Route::get('/detail-buku/{id}','BiblioController@front_detailBiblio')->name('detail-buku');
// Tampilkan buku baru user
Route::get('/buku-baru','BiblioController@front_newBook');
// Tampilkan hasil perhitungan TOPSIS
Route::post('/rekomendasi-buku', 'BiblioController@topsis');
// Tampilkan form TOPSIS input user
Route::get('/form-rekomendasi', 'BiblioController@formTopsis');

// Absensi tanpa login
// Tampilkan form absensi (Email, password, keperluan)
Route::get('/absensi-perpustakaan','VisitController@getFormAbsensi');
// Catat absensi tanpa login
Route::post('/absensi-perpustakaan-catat','VisitController@add_visit_no_login');
// Tampilkan halaman scan QR
Route::get('/absensi-qr-perpustakaan', 'VisitController@getPageScan');
// Catat absensi dengan QR
Route::post('/scan-qr','VisitController@qr_read');

// Menampilkan data author di form TOPSIS
Route::post('/daftar-penulis-combobox','AuthorController@cb_box_author');

Route::middleware(['auth'])->group(function(){
    // Profile Admin
    Route::get('/profile-edit','UserController@getFormEditAdmin');
    Route::post('/ubah-profil-admin','UserController@editDataAdmin');


    // Category
    // Admin akses
    Route::resource('/daftar-kategori','CategoryController');
    // Tambah data kategori
    Route::post('/tambah-kategori','CategoryController@store');
    Route::post('/daftar-kategori/getEditForm','CategoryController@getEditForm');
    // Catat update penerbit
    Route::post('daftar-kategori/updateData','CategoryController@updateData')->name('daftar-kategori.updateData');

    // Publisher
    // Admin Akses

    // Tampilkan data penerbit
    Route::resource('daftar-penerbit', 'PublisherController');
    // Tampilkan edit form penerbit
    Route::post('/daftar-penerbit/getEditForm','PublisherController@getEditForm')->name('daftar-penerbit.getEditForm');
    // Catat update penerbit
    Route::post('daftar-penerbit/updateData','PublisherController@updateData')->name('daftar-penerbit.updateData');

    // Author
    //Admin Akses

    // Tampilkan data penulis
    Route::resource('daftar-penulis', 'AuthorController');
    // Tampilkan edit form penulis
    Route::post('/daftar-penulis/getEditForm','AuthorController@getEditForm')->name('daftar-penulis.getEditForm');
    // Catat update penulis
    Route::post('daftar-penulis/updateData','AuthorController@updateData')->name('daftar-penulis.updateData');

    // Biblio + Item
    //Admin Akses

    // Tampilkan daftar biblio
    Route::resource('daftar-buku', 'BiblioController');
    // Tampilkan daftar item di detail biblio admin
    Route::resource('daftar-item', 'ItemController');
    // Tampilkan detail biblio admin
    Route::get('daftar-buku-detail/{id}','BiblioController@detailBiblio')->name('daftar-buku-detail');
    // Tampilkan edit form biblio
    Route::post('/daftar-buku/getEditForm', 'BiblioController@getEditForm')->name('daftar-buku.getEditForm');
    // Catat update biblio
    Route::post('daftar-buku/updateData','BiblioController@updateData')->name('daftar-buku.updateData');
    // Tampilkan edit form item
    Route::post('/daftar-item/getEditForm', 'ItemController@getEditForm')->name('daftar-item.getEditForm');
    // Catat update item
    Route::post('daftar-item/updateData','ItemController@updateData')->name('daftar-item.updateData');
    // Tampilkan delete form item
    Route::post('daftar-item/getDeleteForm','ItemController@getDeleteForm')->name('daftar-item.getDeleteForm');
    // Catat delete item
    Route::post('daftar-item/deleteData','ItemController@deleteData')->name('daftar-item.deleteData');
    // Tampilkan laporan penghapusan admin
    Route::get('daftar-penghapusan-buku','ItemController@deletion');
    // Tampilkan laporan penghapusan -> filter
    Route::get('/daftar-penghapusan-filter', 'ItemController@deletion_filter');
    // Cetak laporan penghapusan admin
    Route::get('/cetak-laporan-penghapusan','ItemController@printDeleteReport')->name('daftar-penghapusan-buku.printDeleteReport');
    // Tampilkan daftar pesanan admin
    Route::get('/daftar-pesanan-buku','BiblioController@bookingList');
    // Tampilkan daftar pesanan admin -> filter
    Route::get('/daftar-pemesanan-filter','BiblioController@bookingList_filter');

    //User Akses

    // Tampilkan form pesan
    Route::get('/pesan-buku/{id}','BiblioController@formBooking');
    // Catat data pesanan
    Route::post('/pesanan-catat', 'BiblioController@addBooking');
    // Tampilkan daftar pesanan sesuai user login
    Route::get('/daftar-pesanan','BiblioController@myBooking');
    // Catat delete pesanan
    Route::post('/hapus-pesanan','BiblioController@deleteMyBooking');

    //Class
    //Admin Akses

    // Tampilkan daftar kelas
    Route::resource('daftar-kelas', 'ClassesController');
    // Tampilkan form edit kelas
    Route::post('/daftar-kelas/getEditForm','ClassesController@getEditForm')->name('daftar-kelas.getEditForm');
    // Catat update kelas
    Route::post('daftar-kelas/updateData','ClassesController@updateData')->name('daftar-kelas.updateData');

    //Borrow + borrow transaction
    //Admin Akses

    // Tampilkan daftar peminjaman
    Route::resource('daftar-peminjaman', 'BorrowController');
    // Tampilkan daftar peminjaman -> filter
    Route::get('/daftar-peminjaman-filter', 'BorrowController@index_filter');
    // Function cek sebelum tambah data peminjaman
    Route::post('/check-sebelum-tambah','BorrowController@check_before_add_circulation');
    // Tampilkan laporan grafik -> default tahun berjalan
    Route::get('/grafik-peminjaman','BorrowController@graphic');
    // Tampilkan laporan grafik -> filter tahun yang dipilih
    Route::post('/grafik-pinjaman-filter', 'BorrowController@graphicYear');
    // Tampilkan list nama semua pengguna perpustakaan untuk catat peminjaman dan ke detail peminjaman
    Route::get('/sirkulasi-buku','BorrowController@listUser');
    // Tampilkan list nama semua pengguna perpustakaan untuk catat peminjaman dan ke detail peminjaman -> filter 
    Route::get('/sirkulasi-buku-filter','BorrowController@listUser_filter');
    // Tampilkan tiap detail sirkulasi pengguna, history pinjam
    Route::get('sirkulasi-detail/{id}','BorrowController@detailCirculation')->name('sirkulasi-detail');
    // Tampilkan halaman add sirkulasi, daftar pesanan pengguna
    Route::get('/tambah-sirkulasi-buku/{id}','BorrowController@detailAddCirculation');
    // Tampilkan detail peminjaman tiap pengguna dalam bentuk modal 
    Route::post('/daftar-peminjaman/getDetail','BorrowController@getDetail')->name('daftar-peminjaman.getDetail');
    // Tampilkan grafik donat perbandingan berdasarkan range tgl peminjaman
    Route::post('/grafik-perbandingan-peminjaman-filter','BorrowController@doughnutGraphic');
    // Tampilkan grafik donat perbandingan default semua data peminjaman yang ada
    Route::get('/grafik-perbandingan-peminjaman','BorrowController@getDoughnutGraphic');
    // Catat pengembalian buku
    Route::post('/return','BorrowController@bookReturn');
    // Catat perpanjangan buku
    Route::post('/extension','BorrowController@bookExtension');

    // User Akses
    // Tampilkan daftar pinjaman pengguna login
    Route::get('/daftar-pinjaman', 'BorrowController@myBorrow');
    // Catat perpanjangan buku 
    Route::post('/extension-user','BorrowController@bookExtensionUser');

    // Visit
    // Admin
    // Tampilkan semua daftar kunjungan
    Route::resource('kunjungan', 'VisitController');
    // Tampilkan daftar kunjungan -> filter
    Route::get('/kunjungan-filter', 'VisitController@index_filter');
    // Tampilkan grafik pengunjung default tahun yang berjalan
    Route::get('/grafik-pengunjung','VisitController@graphic');
    // Tampilkan grafik pengunjung -> filter tahun
    Route::post('/grafik-pengunjung-filter','VisitController@graphicYear');
    // Tampilkan form keperluan di perpustakaan saat absensi buku tamu
    Route::post('/kunjungan/getAddForm','VisitController@getAddForm')->name('kunjungan.getAddForm');
    // Catat data absesnsi baru dari menu buku tamu
    Route::post('/tambah-kunjungan','VisitController@addVisit')->name('kunjungan.addVisit');
    // Tampilkan laporan kunjungan
    Route::get('/laporan-kunjungan','VisitController@listVisit');
    // Tampilkan laporan kunjungan -> filter
    Route::get('/laporan-kunjungan-filter', 'VisitController@listVisit_filter');
    // Cetak laporan kunjungan
    Route::get('/cetak-laporan-kunjungan','VisitController@printVisitReport');

    // User
    // Tampilkan form absensi kunjungan
    Route::get('/form-masuk','VisitController@getVisitForm');
    // Catat data kunjungan baru
    Route::post('/masuk-perpustakaan-catat','VisitController@visitUserAdd');
    // Tampilkan daftar riwayat kunjungan user login
    Route::get('/riwayat-kunjungan', 'VisitController@history_visit');

    // User + suggestion
    // Tampilkan daftar murid
    Route::get('/daftar-murid', 'UserController@student')->name('daftar-murid.murid');
    // Tampilkan daftar guru
    Route::get('/daftar-guru', 'UserController@teacher');
    // Tampilkan daftar usulan buku
    Route::resource('daftar-usulan-buku', 'SuggestionController');
    // Tampilkan form update data usulan
    Route::post('/daftar-usulan-buku/getEditForm','SuggestionController@getEditForm')->name('daftar-usulan-buku.getEditForm');
    // Catat update status usulan
    Route::post('daftar-usulan-buku/updateData','SuggestionController@updateData')->name('daftar-usulan-buku.updateData');
    // Catat update status is_deleted di tabel usulan (Yang bs hapus permanen user yg pny usulan)
    Route::post('daftar-usulan-buku/deleteDataAdmin','SuggestionController@deleteDataAdmin')->name('suggestions.deleteDataAdmin');
    // Cetak daftar usulan
    Route::get('/cetak-usulan','SuggestionController@printSuggestionReport');
    // Tampilkan form ubah data user
    Route::get('/ubah-data-pengguna/{id}', 'UserController@getEditForm');
    // Catat update data user bagian admin
    Route::post('/aksi-ubah-data', 'UserController@editDataUserAdmin');
    // Catat update aktif user
    Route::get('/non-aktif-user/{id}','UserController@is_active');
    // Tampilkan daftar usulan buku -> filter
    Route::get('/daftar-usulan-buku-filter', 'SuggestionController@filter_data');

    // User akses
    // Tampilkan profil user login, barcode
    Route::get('/profil', 'UserController@getProfileUser');
    // Catat edit password
    Route::post('/editPassword', 'UserController@editPasswordUser');
    // Tampilkan form usulan
    Route::get('/form-usulan','SuggestionController@getSugesstionForm');
    // Tampilkan daftar usulan user login
    Route::get('/usulan-saya','SuggestionController@mySuggestion');
    // Catat usulan baru
    Route::post('/usulan-catat','SuggestionController@addSuggestionUser');
    // Tampilkan semua daftar usulan yang ada dari semua user
    Route::get('/daftar-usulan', 'SuggestionController@front_index');
    // Tampilkan form ubah usulan
    Route::get('/ubah-usulan/{id}', 'SuggestionController@getEditFormUser');
    // Catat update usulan
    Route::post('/ubah-usulan-catat', 'SuggestionController@editSuggestion');
    // Catat delete usulan
    Route::get('/hapus-usulan/{id}', 'SuggestionController@deleteSuggestionUser');
});
