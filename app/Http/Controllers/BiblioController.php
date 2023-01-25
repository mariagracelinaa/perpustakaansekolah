<?php

namespace App\Http\Controllers;

use App\Biblio;
use App\Publisher;
use App\Deletion;
use App\Item;
use App\Category;
use App\Author;
use Illuminate\Http\Request;
use DB;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Auth;

class BiblioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-admin');
        $result = Biblio::all();
        $publisher = Publisher::all();
        $author = Author::all();
        $category = Category::all();
        return view('biblio.index', compact('result', 'publisher', 'author', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('check-admin');
        // dd($request->get('category'));
        // dd($request);
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'isbn' => 'required',
            'listPublisher' => 'required',
            'listAuthor' => 'required',
            'publish_year' => 'required',
            'first_purchase' => 'required',
            'category' => 'required',
            'classification' => 'required',
            'edition' => 'required',
            'image' => 'image',
            'page' => 'required',
            'height' => 'required',
            'location' => 'required',
            'synopsis' => 'required',
        ],
        [
            'title.required' => 'Judul tidak boleh kosong',
            'isbn.required' => 'Nomor ISBN tidak boleh kosong',
            'listPublisher.required' => 'Penerbit tidak boleh kosong',
            'listAuthor.required' => 'Penulis tidak boleh kosong',
            'publish_year.required' => 'Tahun terbit tidak boleh kosong. Jika tidak diketahui isikan 0',
            'first_purchase.required' => 'Tahun pertama pengadaan tidak boleh kosong. Jika tidak diketahui isikan 0',
            'category.required' => 'Kategori tidak boleh kosong',
            'classification.required' => 'Nomor panggil buku tidak boleh kosong',
            'edition.required' => 'Edisi tidak boleh kosong. Jika tidak diketahui isikan 1',
            'page.required' => 'Jumlah halaman tidak boleh kosong',
            'image.required' => 'File harus berupa gambar',
            'height.required' => 'Tinggi buku tidak boleh kosong',
            'location.required' => 'Lokasi buku tidak boleh kosong',
            'synopsis.required' => 'Sinopsis buku tidak boleh kosong',
        ]);
        
        if (!$validator->passes())
        {
            return response()->json(['status'=>0, 'errors'=>$validator->errors()->toArray()]);
        }else{
            try{
            // Ambil id peneribit sesuai nama yang dimasukkan pengguna
                $pub_id = DB::table('publishers')
                        ->select()
                        ->where('name', '=', $request->get('listPublisher'))
                        ->get();
                

                // // Ambil id penulis sesuai nama yang dimasukkan pengguna
                $arr_author = $request->get('listAuthor');
                $arr_id = [];
                for($i = 0; $i < count($arr_author); $i++){
                    $id = DB::table('authors')
                            ->select()
                            ->where('name', '=', $arr_author[$i])
                            ->get();

                    $arr_id[$i] = $id[0]->id;
                }

                // // Save ke biblio
                $biblio = new Biblio();
                $biblio->title = $request->get('title');
                $biblio->isbn = $request->get('isbn');
                $biblio->publishers_id = $pub_id[0]->id;
                $biblio->publish_year = $request->get('publish_year');
                $biblio->first_purchase = $request->get('first_purchase');
                $biblio->categories_id = $request->get('category');
                $biblio->classification = $request->get('classification');
                
                $ext = $request->file('image')->extension();
                $file = $request->file('image');
                $file = Image::make($file);
                $file->resize(300, 400);
                $imgFolder = 'images';
                // $imgFile = $file->getClientOriginalName();
                $imgFile = $request->get('title').'.'.$ext;
                $file->save(public_path('images/') . $imgFile);
                // $file->move($imgFolder, $imgFile);
                $image = $imgFile;
                
                $biblio->image = $image;

                $biblio->edition = $request->get('edition');
                $biblio->page = $request->get('page');
                $biblio->book_height = $request->get('height');
                $biblio->location = $request->get('location');
                $biblio->synopsis = $request->get('synopsis');
                // dd($biblio);
                $biblio->save();

                if($biblio){
                    // // Save ke authors_biblios
                    for($j = 0; $j < count($arr_id); $j++){
                        if($j == 0){
                            $auth_biblio = DB::table('authors_biblios')
                                    ->insert(['authors_id' => $arr_id[$j], 'biblios_id' => $biblio->id, 'primary_author' => 1]);
                        }else{
                            $auth_biblio = DB::table('authors_biblios')
                                    ->insert(['authors_id' => $arr_id[$j], 'biblios_id' => $biblio->id, 'primary_author' => 0]);
                        }        
                    }
                }
                return session()->flash('status','Data buku baru berhasil disimpan');
            }catch (\PDOException $e) {
                return session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Biblio  $biblio
     * @return \Illuminate\Http\Response
     */
    public function show(Biblio $biblio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Biblio  $biblio
     * @return \Illuminate\Http\Response
     */
    public function edit(Biblio $biblio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Biblio  $biblio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Biblio $biblio)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Biblio  $biblio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Biblio $biblio)
    {
        //
    }

    public function populerBook(){
        $data = DB::table('borrow_transaction')
            ->join('items','items.register_num','=','borrow_transaction.register_num')
            ->join('biblios','biblios.id','=','items.biblios_id')
            ->select('biblios.id', 'biblios.title','biblios.image',DB::raw('COUNT(*) as count'))
            ->groupBy('biblios.id')
            ->groupBy('biblios.title')
            ->groupBy('biblios.image')
            ->orderBy('count','desc')
            ->limit(10)
            ->get();

        // dd($data);
        return view('frontend.populerbook', compact('data'));
    }

    public function detailBiblio($biblios_id){
        $this->authorize('check-admin');
        //Ambil data biblio sesuai ID yang ingin dilihat detailnya
        $data = Biblio::find($biblios_id);

        //Ambil data author sesuai biblio
        $listAuthorBiblio = DB::table('authors_biblios')
                            ->where('biblios_id', $biblios_id)
                            ->orderBy('primary_author', 'desc')
                            ->get();

        $author_name = [];

        //Masukin nama author berdasarkan id yang ada
        for($i = 0; $i < count($listAuthorBiblio); $i++){
            $name = DB::table('authors')
                ->select()
                ->where('id', '=', $listAuthorBiblio[$i]->authors_id)
                ->get();

            $author_name[$i] = $name[0]->name;  
        } 
        //Ambil semua item dari biblio yang dimaksud
        $items = $data->items;
        return view('biblio.detailbiblio', compact('data','items', 'author_name'));
    }

    public function getEditForm(Request $request){
        $id = $request->get('id');
        $data = Biblio::find($id);

        $listAuthorBiblio = DB::table('authors_biblios')
                            ->where('biblios_id', $id)
                            ->orderBy('primary_author', 'desc')
                            ->get();

        $author_data = [];

        for($i = 0; $i < count($listAuthorBiblio); $i++){
            $auth = DB::table('authors')
                ->select()
                ->where('id', '=', $listAuthorBiblio[$i]->authors_id)
                ->get();

            $author_data[$i] = $auth[0]->name;  
        }

        $publisher = Publisher::all();
        $author = Author::all();
        $category = Category::all();

        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('biblio.getEditForm', compact('data','author_data','publisher','author','category'))->render()
        ), 200);
    }

    public function getAddForm(){
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('biblio.getAddForm')
        ), 200);
    }

    public function updateData(Request $request){
        $this->authorize('check-admin');
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'isbn' => 'required',
            'listPublisher' => 'required',
            'listAuthor' => 'required',
            'publish_year' => 'required',
            'first_purchase' => 'required',
            'category' => 'required',
            'classification' => 'required',
            'edition' => 'required',
            'page' => 'required',
            'image' => 'image',
            'height' => 'required',
            'location' => 'required',
            'synopsis' => 'required',
        ],
        [
            'title.required' => 'Judul tidak boleh kosong',
            'isbn.required' => 'Nomor ISBN tidak boleh kosong',
            'listPublisher.required' => 'Penerbit tidak boleh kosong',
            'listAuthor.required' => 'Penulis tidak boleh kosong',
            'publish_year.required' => 'Tahun terbit tidak boleh kosong. Jika tidak diketahui isikan 0',
            'first_purchase.required' => 'Tahun pertama pengadaan tidak boleh kosong. Jika tidak diketahui isikan 0',
            'category.required' => 'Kategori tidak boleh kosong',
            'classification.required' => 'Nomor panggil buku tidak boleh kosong',
            'edition.required' => 'Edisi tidak boleh kosong. Jika tidak diketahui isikan 1',
            'page.required' => 'Jumlah halaman tidak boleh kosong',
            'height.required' => 'Tinggi buku tidak boleh kosong',
            'location.required' => 'Lokasi buku tidak boleh kosong',
            'synopsis.required' => 'Sinopsis buku tidak boleh kosong',
        ]);
        
        if (!$validator->passes())
        {
            return response()->json(['status'=>0, 'errors'=>$validator->errors()->toArray()]);
        }else{
            try{
                // Ambil id peneribit sesuai nama yang dimasukkan pengguna
                $pub_id = DB::table('publishers')
                        ->select()
                        ->where('name', '=', $request->get('listPublisher'))
                        ->get();

                $old_image = DB::table('biblios')
                            ->select()
                            ->where('id','=', $request->get('id'))
                            ->get();
                

                // Ambil id penulis sesuai nama yang dimasukkan pengguna
                $arr_author = $request->get('listAuthor');
                $arr_id = [];
                for($i = 0; $i < count($arr_author); $i++){
                    $id = DB::table('authors')
                            ->select()
                            ->where('name', '=', $arr_author[$i])
                            ->get();

                    $arr_id[$i] = $id[0]->id;
                }

                $title = $request->get('title');
                $isbn = $request->get('isbn');
                $publishers_id = $pub_id[0]->id;
                $publish_year = $request->get('publish_year');
                $first_purchase = $request->get('first_purchase');
                $categories_id = $request->get('category');
                $classification = $request->get('classification');
                
                // Hapus foto lama terlebih dahulu 
                // dd($old_image[0]->image);
                // Storage::delete();

                // Cek apakah ada file gmbr
                if($request->hasFile('image')){
                    File::delete(public_path('images/'.$old_image[0]->image));

                    // Simpan foto baru
                    // $file = $request->file('image');
                    // $imgFolder = 'images';
                    // $imgFile = $request->file('image')->getClientOriginalName();
                    // $file->move($imgFolder, $imgFile);
                    // $image = $imgFile;

                    $ext = $request->file('image')->extension();
                    $file = $request->file('image');
                    $file = Image::make($file);
                    $file->resize(300, 400);
                    $imgFolder = 'images';
                    // $imgFile = $file->getClientOriginalName();
                    $imgFile = $title.'.'.$ext;
                    $file->save(public_path('images/') . $imgFile);
                    // $file->move($imgFolder, $imgFile);
                    $image = $imgFile;

                    $data = DB::table('biblios')
                        ->where('id', $request->get('id'))
                        ->update(['image' => $image]);
                }
                
                $edition = $request->get('edition');
                $page = $request->get('page');
                $book_height = $request->get('height');
                $location = $request->get('location');
                $synopsis = $request->get('synopsis');

                // dd($title, $isbn , $publish_year, $publishers_id, $first_purchase, $categories_id, $classification, $image, $edition, $page, $book_height, $location);

                $data = DB::table('biblios')
                        ->where('id', $request->get('id'))
                        ->update(['title' => $title, 'isbn' => $isbn, 'publishers_id' => $publishers_id,'publish_year' => $publish_year, 'first_purchase' => $first_purchase, 'categories_id' => $categories_id, 'classification' => $classification, 'edition' => $edition, 'page' => $page, 'book_height' => $book_height, 'location' => $location, 'synopsis' => $synopsis]);

                $delete = DB::table('authors_biblios')->where('biblios_id', '=', $request->get('id'))->delete();

                // Save ke authors_biblios
                for($j = 0; $j < count($arr_id); $j++){
                    if($j == 0){
                        $auth_biblio = DB::table('authors_biblios')
                                ->insert(['authors_id' => $arr_id[$j], 'biblios_id' => $request->get('id'), 'primary_author' => 1]);
                    }else{
                            $auth_biblio = DB::table('authors_biblios')
                                ->insert(['authors_id' => $arr_id[$j], 'biblios_id' => $request->get('id'), 'primary_author' => 0]);
                    }        
                }
                $request->session()->flash('status','Data buku berhasil diubah');
                
            }catch (\PDOException $e) {
                $request->session()->flash('error', 'Gagal mengubah data buku, silahkan coba lagi');
            }  
        }
    }

    public function bookingList(){
        $this->authorize('check-admin');
        $filter = "";

        $start = "";
        $end = "";
        $status = "";
        $data = DB::table('bookings')
                ->join('biblios', 'biblios.id','=','bookings.biblios_id')
                ->join('users','users.id','=','bookings.users_id')
                ->select('users.name', 'users.id', 'biblios.title', 'bookings.booking_date','bookings.description','bookings.status')
                ->orderBy('booking_date','ASC')
                ->get();
        // dd($data);
        return view('booking.index', compact('data', 'start', 'end','filter','status'));
    }

    public function mostBooking(){
        $this->authorize('check-admin');

        $data = DB::table('bookings')
                ->join('biblios','biblios.id','bookings.biblios_id')
                ->join('authors_biblios','biblios.id','authors_biblios.biblios_id')
                ->join('authors','authors.id','authors_biblios.authors_id')
                ->join('publishers','biblios.publishers_id','publishers.id')
                ->select('biblios.id','biblios.image','biblios.title','authors.name as author','publishers.name as publisher', DB::raw('COUNT(*) as count'))
                ->where('authors_biblios.primary_author','=',1)
                ->groupBy('biblios.id')
                ->groupBy('biblios.image')
                ->groupBy('biblios.title')
                ->groupBy('publishers.name')
                ->groupBy('authors.name')
                ->orderBy('count','desc')
                ->get();

        // dd($data);
        return view('booking.populer', compact('data'));
    }

    public function bookingList_filter(Request $request){
        $this->authorize('check-admin');
        $filter = $request->get('filter');
        $start = $request->get('date_start');
        $end = $request->get('date_end');
        $status = $request->get('status');

        if($filter == "date"){
            $data = DB::table('bookings')
                ->join('biblios', 'biblios.id','=','bookings.biblios_id')
                ->join('users','users.id','=','bookings.users_id')
                ->select('users.name', 'biblios.title', DB::raw('DATE_FORMAT(bookings.booking_date, "%d-%m-%Y") as booking_date'),'bookings.description','bookings.status')
                ->whereBetween('booking_date', [$start, $end])
                ->orderBy('booking_date','ASC')
                ->get();
        }else if($filter == "status"){
            $data = DB::table('bookings')
                ->join('biblios', 'biblios.id','=','bookings.biblios_id')
                ->join('users','users.id','=','bookings.users_id')
                ->select('users.name', 'biblios.title', DB::raw('DATE_FORMAT(bookings.booking_date, "%d-%m-%Y") as booking_date'),'bookings.description','bookings.status')
                ->where('status', '=', $status)
                ->orderBy('booking_date','ASC')
                ->get();
        }else{
            $data = DB::table('bookings')
                ->join('biblios', 'biblios.id','=','bookings.biblios_id')
                ->join('users','users.id','=','bookings.users_id')
                ->select('users.name', 'biblios.title', 'bookings.booking_date','bookings.description','bookings.status')
                ->orderBy('booking_date','ASC')
                ->get();
        }
        
        return view('booking.index', compact('data', 'start', 'end','filter', 'status'));
    }

    // ----------------------------------------- FRONT END ------------------------------------------------

    public function front_index(){
        $result = Biblio::select()->orderBy('id','desc')->limit(4)->get();
        // dd($result);
        return view('frontend.index', compact('result'));
    }

    public function front_detailBiblio($biblios_id){
        //Ambil data biblio sesuai ID yang ingin dilihat detailnya
        $data = Biblio::find($biblios_id);

        //Ambil data author sesuai biblio
        $listAuthorBiblio = DB::table('authors_biblios')
                            ->where('biblios_id', $biblios_id)
                            ->orderBy('primary_author', 'desc')
                            ->get();

        $author_name = [];

        //Masukin nama author berdasarkan id yang ada
        for($i = 0; $i < count($listAuthorBiblio); $i++){
            $name = DB::table('authors')
                ->select()
                ->where('id', '=', $listAuthorBiblio[$i]->authors_id)
                ->get();

            $author_name[$i] = $name[0]->name;  
        } 
        //Ambil semua item dari biblio yang dimaksud
        $items = $data->items;

        $count = DB::table('items')
                ->where('biblios_id','=', $biblios_id)
                ->where('status','=','tersedia')
                ->where('is_deleted','=',0)
                ->select(DB::raw('COUNT(*) as count'))
                ->get();

        // dd($count);
        $count_borrow = DB::table('borrow_transaction')
            ->join('items', 'items.register_num', '=', 'borrow_transaction.register_num')
            ->select(DB::raw('COUNT(*) as count'))
            ->where('items.biblios_id','=', $biblios_id)
            ->get();

        // baca review
        $review = DB::table('book_ratings')
                ->join('users','users.id','=','book_ratings.users_id')
                ->select('book_ratings.*','users.name')
                ->where('book_ratings.biblios_id','=',$biblios_id)
                ->orderBy('book_ratings.date','desc')
                ->limit(3)
                ->get();
        // hitung rating buku
        // total rating x jumlah
        $total_book_rating = 0;
        for ($i=1; $i <= 5; $i++) { 
            $cr = DB::table('book_ratings')
                    ->select(DB::raw('COUNT(*) as count'))
                    ->where('rate','=',$i)
                    ->where('biblios_id','=',$biblios_id)
                    ->get();
            
            $total_book_rating = $total_book_rating + ($i * $cr[0]->count);
        }
        // dd($total_book_rating);
        // Dapatkan nilai rating range 1-5
        $cs = DB::table('book_ratings')
                    ->select(DB::raw('COUNT(*) as reviewer'))
                    ->where('biblios_id','=',$biblios_id)
                    ->get();
    
        if($cs[0]->reviewer == 0){
            $rating = 0;
        }else{
           $rating = $total_book_rating / $cs[0]->reviewer; 
        }

        // Baca review dari user tertentu
        $book_rating_user = NULL;
        if(Auth::user()){
            $book_rating_user = DB::table('book_ratings')
                                ->select()
                                ->where('biblios_id','=', $biblios_id)
                                ->where('users_id','=', Auth::user()->id)
                                ->get();
            if(!$book_rating_user->isEmpty()){
                $book_rating_user = $book_rating_user[0];
            }else{
                $book_rating_user = NULL;
            }
        }
        
        // dd($book_rating_user);
        return view('frontend.detail', compact('data','items', 'author_name','count','count_borrow','review','rating','book_rating_user'));
    }

    public function front_newBook(){
        $current_year = date('Y');
        $last_year = $current_year - 1;


        $data = DB::table('biblios')->select()->where('first_purchase','=',$current_year)->orWhere('first_purchase','=', $last_year)->orderBy('id','desc')->get();
        // dd($data);
        return view('frontend.newbook', compact('data'));
    }

    public function formBooking($id){
        $this->authorize('check-user');
        $title = DB::table('biblios')->select('title')->where('id','=',$id)->get();
        // dd($id, $title);
        return view('frontend.formBooking', compact('id','title'));
    }

    public function addBooking(Request $request){
        $this->authorize('check-user');
        // dd($request->get('id'), $request->get('biblios_id'), $request->get('desc'));
        $biblios_id = $request->get('biblios_id');
        $users_id = $request->get('id');
        $desc = $request->get('desc');

        $count = DB::table('bookings')->select(DB::raw('COUNT(*) as count'))->where('biblios_id','=',$biblios_id)->where('users_id','=',$users_id)->get();

        $count = $count[0]->count;
        $count = $count+1;
        $bookings_id = $biblios_id."/".$users_id."/".$count."/proses";
        $date = Carbon::now()->format('Y-m-d H:i:s');
        // dd($date);

        try{
            // Cek apakah sudah ada pesanan aktif dengan id user dan id biblio yang masih proses?
            $check_booking = DB::table('bookings')->select()->where('users_id','=',$users_id)->where('biblios_id','=',$biblios_id)->where('status','=','proses')->get();

            // dd($check_booking);

            if(count($check_booking) > 0){
                return redirect('/detail-buku/'.$request->get('biblios_id'))->with('error', 'Buku sudah ada didaftar pesanan');
            }else{
                DB::table('bookings')->insert(
                    ['id' => $bookings_id,'biblios_id' => $biblios_id , 'users_id' => $users_id, 'booking_date' => $date, 'description' => $desc, 'status' => 'proses']
                );
            }  

            return redirect('/detail-buku/'.$request->get('biblios_id'))->with('status','Berhasil memesan buku');
        }catch (\PDOException $e) {
            return redirect('/detail-buku/'.$request->get('biblios_id'))->with('error', 'Gagal memesan buku, silahkan coba lagi');
        }
    }

    public function myBooking(){
        $this->authorize('check-user');
        $id = Auth::user()->id;
        
        $data = DB::table('bookings')
                ->join('biblios', 'biblios.id','=','bookings.biblios_id')
                ->select('biblios.id','biblios.title', 'bookings.booking_date','bookings.description','bookings.id as bid','bookings.status')
                ->where('users_id','=',$id)
                ->orderBy('booking_date','ASC')
                ->get();
        return view('frontend.myBooking', compact('data'));
    }

    public function deleteMyBooking(Request $request){
        $this->authorize('check-user');
        $bookings_id = $request->get('bookings_id');
        $users_id = $request->get('id');
        $biblios_id = $request->get('biblios_id');
        // dd($users_id, $biblios_id);
        $arr_id = [];
        $i = 0;
        foreach(explode('/', $bookings_id) as $fields) {
            $arr_id[$i] = $fields;
            $i++;
        }
        // dd("halo");

        try{
            $new_id = $biblios_id."/".$users_id."/".$arr_id[2]."/dibatalkan";
            DB::table('bookings')->where('id', '=', $bookings_id)->update(['id' => $new_id ,'status' => "dibatalkan"]);
            return session()->flash('status','Berhasil membatalkan pemesanan buku');
        }catch (\PDOException $e) {
            return session()->flash('error', 'Gagal membatalkan pemesanan buku, silahkan coba lagi');
        }
        
    }

    public function addReview(Request $request){
        $this->authorize('check-user');
        try{
            $biblios_id = $request->get('biblios_id');
            $users_id = $request->get('users_id');
            $comment = $request->get('comment');
            $book_rating = $request->get('book_rating');
            $date = Carbon::now();

            // cek apa sudah ada data review nya
            $rate = DB::table('book_ratings')
                    ->select()
                    ->where('biblios_id','=', $biblios_id)
                    ->where('users_id','=',$users_id)
                    ->get();
            if(!$rate->isEmpty()){
                DB::table('book_ratings')
                ->where('biblios_id', $biblios_id)
                ->where('users_id', $users_id)
                ->update(['rate' => $book_rating, 'comment' => $comment, 'date' => $date]);
            }else{
                DB::table('book_ratings')
                ->insert(['biblios_id' => $biblios_id, 'users_id' => $users_id, 'rate' => $book_rating, 'comment' => $comment, 'date' => $date]);
            }

            return redirect()->back()->with('status', 'Review berhasil dicatat');
        }catch (\PDOException $e) {
            return redirect()->back()->with('error', 'Review gagal dicatat, silahkan coba lagi!');
        }
    }

    public function formTopsis(){
        $author = Author::all();
        $category = DB::table('categories')->select()->orderBy('name','asc')->get();
        // dd($category);
        return view('frontend.formTopsis',compact('author','category'));
    }

    public function topsis(Request $request){
        // dd($request->get('category'), $request->get('radio_borrow'),$request->get('radio_page'),$request->get('radio_publish'), $request->get('radio_age'));

        if($request->get('category') == 1000){
            return redirect()->back()->with('error', 'Kategori buku tidak boleh kosong, pilih salah satu kategori buku yang diinginkan');
        }else{
            // Bobot dari user
            $bobot_k1 = $request->get('radio_borrow');
            $bobot_k2 = $request->get('radio_page');
            // $bobot_k3 = $request->get('radio_publish');
            $bobot_k3 = 1;
            if($request->get('fav_author') != ""){
                $bobot_k3 = 5;
            }
            $bobot_k4 = $request->get('radio_age');
            $bobot_k5 = $request->get('radio_stock');
            $bobot_k6 = $request->get('radio_book_rating');
            $bobot_k7 = $request->get('radio_author_rating');
            // dd($bobot_k1, $bobot_k2,$bobot_k3, $bobot_k4,$bobot_k5, $bobot_k6,$bobot_k7);
            
            // $bobot_k1 = 5;
            // $bobot_k2 = 3;
            // $bobot_k3 = 1;
            // $bobot_k4 = 5;
            // $bobot_k5 = 2;
            // $bobot_k6 = 5;
            // $bobot_k7 = 5;
            // bobot x -> kesesuaian penulis, kalo ada isinya cocok kasih 5. kalo gaada isi/ga cocok kasih 3

            // bobot 5 -> stok buku diperpustakaan, jika stok ada kasih 5, jika kosong kasih 1
            
            if($request->get('category') == 000 || $request->get('category') == 100 || $request->get('category') == 200 || $request->get('category') == 300 || $request->get('category') == 400 || $request->get('category') == 500 || $request->get('category') == 600 || $request->get('category') == 700 || $request->get('category') == 800 || $request->get('category') == 900){
                // Query untuk ambil data buku dari db sesuai kategori DDC user
                $book = DB::table('biblios')
                        ->join('categories','categories.id','=','biblios.categories_id')
                        ->select('biblios.*')
                        ->where('categories.ddc','=', $request->get('category'))
                        ->orderBy('id')
                        ->get();      
            }else{
                $book = DB::table('biblios')
                    ->select()
                    ->where('categories_id','=',$request->get('category'))
                    ->get();
            }
            
            // ---------------------------------------------------- Decision Matrix ------------------------------------------------------
            // Query untuk cari jumlah buku terpinjam -> K1
            // id biblios jadi index
            $arr_count_borrow = [];
            foreach($book as $bk){
                // dd($bk->id);
                $count_borrow = DB::table('borrow_transaction')
                                ->join('items', 'items.register_num', '=', 'borrow_transaction.register_num')
                                ->select(DB::raw('COUNT(*) as count'))
                                ->where('items.biblios_id','=', $bk->id)
                                ->get();
                $arr_count_borrow[$bk->id] = $count_borrow[0];
            }
            // dd($arr_count_borrow);

            // Query jumlah halaman buku -> K2
            $arr_count_page = [];
            foreach($book as $bk){
                // dd($bk->id);
                $count_page = DB::table('biblios')
                                ->select('biblios.page')
                                ->where('biblios.id','=', $bk->id)
                                ->get();
                $arr_count_page[$bk->id] = $count_page[0];
            }
            // dd($arr_count_page);

            // Query cek penulis fav -> K3
            $arr_author = [];
            if($request->get('fav_author') != ""){
                foreach($book as $bk){
                    // dd($bk->id);
                    $id_author = DB::table('authors_biblios')
                                    ->select('authors_id')
                                    ->where('biblios_id','=', $bk->id)
                                    ->get();
                    // array untuk cek di in_array
                    $arr_id = [];
                    for($j = 0; $j < count($id_author); $j++){
                        $arr_id[] = $id_author[$j]->authors_id;
                    }
                    // dd($id_author);
                    if(in_array($request->get('fav_author'), $arr_id)){
                        $arr_author[$bk->id] = 5;
                    }else{
                        $arr_author[$bk->id] = 1;
                    }
                }
            }else{
                foreach($book as $bk){
                    $arr_author[$bk->id] = 1;
                }
            }
            // dd($arr_author);

            // Query usia buku di perpustakaan -> K4
            $arr_age = [];
            foreach($book as $bk){
                // dd($bk->id);
                $age = DB::table('biblios')
                                ->select(DB::raw('YEAR(CURDATE()) - biblios.first_purchase AS age'))
                                ->where('biblios.id','=', $bk->id)
                                ->get();
                $arr_age[$bk->id] = $age[0];
            }
            // dd($arr_age);

            // Query stock buku di perpustakaan
            $arr_stock = [];
            foreach($book as $bk){
                $stock = DB::table('items')
                        ->where('biblios_id','=', $bk->id)
                        ->where('status','=','tersedia')
                        ->where('is_deleted','=',0)
                        ->select(DB::raw('COUNT(*) as stock'))
                        ->get();
                $arr_stock[$bk->id] = $stock[0];
            }
            // dd($arr_stock);

            // Query rating buku
            $arr_book_rating = [];
            foreach($book as $bk){
                $total_book_rating = 0;
                for ($i=1; $i <= 5; $i++) { 
                    $cr = DB::table('book_ratings')
                            ->select(DB::raw('COUNT(*) as count'))
                            ->where('rate','=',$i)
                            ->where('biblios_id','=',$bk->id)
                            ->get();
                    
                    $total_book_rating = $total_book_rating + ($i * $cr[0]->count);
                }
                
                // Dapatkan nilai rating range 1-5
                $cs = DB::table('book_ratings')
                            ->select(DB::raw('COUNT(*) as reviewer'))
                            ->where('biblios_id','=',$bk->id)
                            ->get();
            
                if($cs[0]->reviewer == 0){
                    $arr_book_rating[$bk->id] = 0;
                }else{
                    $arr_book_rating[$bk->id] = round(($total_book_rating / $cs[0]->reviewer),1); 
                }
            }
            // dd($arr_book_rating);

            // dapet penulis utama tiap buku
            $arr_primary_author = [];
            foreach($book as $bk){
                
                $id_author = DB::table('authors_biblios')
                            ->select('authors_id')
                            ->where('primary_author','=',1)
                            ->where('biblios_id','=', $bk->id)
                            ->get();
                $arr_primary_author[$bk->id] = $id_author[0]->authors_id;
            }
            // dd($arr_primary_author);

            // hitung rating penulis
            // total rating x jumlah
            $arr_author_rating = [];
            foreach($book as $bk){
                $total_author_rating = 0;
                for ($i=1; $i <= 5; $i++) { 
                    $cr = DB::table('author_ratings')
                            ->select(DB::raw('COUNT(*) as count'))
                            ->where('rate','=',$i)
                            ->where('authors_id','=',$arr_primary_author[$bk->id])
                            ->get();
                    
                    $total_author_rating = $total_author_rating + ($i * $cr[0]->count);
                }
                // Dapatkan nilai rating range 1-5
                $cs = DB::table('author_ratings')
                        ->select(DB::raw('COUNT(*) as authorRate'))
                        ->where('authors_id','=',$arr_primary_author[$bk->id])
                        ->get();

                if($cs[0]->authorRate == 0){
                    $arr_author_rating[$bk->id] = 0;
                }else{
                    $arr_author_rating[$bk->id] = round(($total_author_rating / $cs[0]->authorRate),1); 
                }
            }
            // dd($arr_author_rating);

            // ---------------------------------------------------- Matrix R ------------------------------------------------------
            // Setiap decision matrix dipangkat 2
            $pow_count_borrow = [];
            $pow_count_page = [];
            $pow_author = [];
            $pow_age = [];
            $pow_stock = [];
            $pow_book_rating = [];
            $pow_author_rating = [];
            // $pow_edition = [];
            foreach($book as $bk){
                $pow_count_borrow[$bk->id] = $arr_count_borrow[$bk->id]->count * $arr_count_borrow[$bk->id]->count;
                $pow_count_page[$bk->id] = $arr_count_page[$bk->id]->page * $arr_count_page[$bk->id]->page;
                $pow_author[$bk->id] = $arr_author[$bk->id] * $arr_author[$bk->id];
                $pow_age[$bk->id] = $arr_age[$bk->id]->age * $arr_age[$bk->id]->age;
                $pow_stock[$bk->id] = $arr_stock[$bk->id]->stock * $arr_stock[$bk->id]->stock;
                $pow_book_rating[$bk->id] = $arr_book_rating[$bk->id] * $arr_book_rating[$bk->id];
                $pow_author_rating[$bk->id] = $arr_author_rating[$bk->id] * $arr_author_rating[$bk->id];
            }
            // dd($pow_book_rating, $pow_author_rating);

            //Total semua nilai buku disetiap kriteria
            $k1 = 0;
            $k2 = 0;
            $k3 = 0;
            $k4 = 0;
            $k5 = 0;
            $k6 = 0;
            $k7 = 0;

            foreach($pow_count_borrow as $acb){
                $k1 = $k1 + $acb;
            }
            
            foreach($pow_count_page as $acp){
                $k2 = $k2 + $acp;
            }

            foreach($pow_author as $aa){
                $k3 = $k3 + $aa;
            }

            foreach($pow_age as $aa){
                $k4 = $k4 + $aa;
            }

            foreach($pow_stock as $as){
                $k5 = $k5 + $as;
            }

            foreach($pow_book_rating as $abr){
                $k6 = $k6 + $abr;
            }

            foreach($pow_author_rating as $aar){
                $k7 = $k7 + $aar;
            }

            // dd($k1, $k2, $k3, $k4, $k5, $k6, $k7);

            // Akar total dari tiap kriteria yang ada
            $sqrt_k1 = sqrt($k1);
            $sqrt_k2 = sqrt($k2);
            $sqrt_k3 = sqrt($k3);
            $sqrt_k4 = sqrt($k4);
            $sqrt_k5 = sqrt($k5);
            $sqrt_k6 = sqrt($k6);
            $sqrt_k7 = sqrt($k7);

            // dd($sqrt_k1, $sqrt_k2, $sqrt_k3, $sqrt_k4, $sqrt_k5, $sqrt_k6, $sqrt_k7);

            // Bagi nilai awal matrix dengan hasil akar
            $matrix_r_k1 = [];
            $matrix_r_k2 = [];
            $matrix_r_k3 = [];
            $matrix_r_k4 = [];
            $matrix_r_k5 = [];
            $matrix_r_k6 = [];
            $matrix_r_k7 = [];
            foreach($book as $bk){
                $matrix_r_k1[$bk->id] = $arr_count_borrow[$bk->id]->count / $sqrt_k1;
                $matrix_r_k2[$bk->id] = $arr_count_page[$bk->id]->page / $sqrt_k2;
                $matrix_r_k3[$bk->id] = $arr_author[$bk->id] / $sqrt_k3;
                $matrix_r_k4[$bk->id] = $arr_age[$bk->id]->age / $sqrt_k4;
                $matrix_r_k5[$bk->id] = $arr_stock[$bk->id]->stock / $sqrt_k5;
                $matrix_r_k6[$bk->id] = $arr_book_rating[$bk->id] / $sqrt_k6;
                $matrix_r_k7[$bk->id] = $arr_author_rating[$bk->id] / $sqrt_k7;
            }

            // dd($matrix_r_k1, $matrix_r_k2, $matrix_r_k3 , $matrix_r_k4, $matrix_r_k5, $matrix_r_k6, $matrix_r_k7);

            // ---------------------------------------------------- Matrix V ------------------------------------------------------
            // Kalikan bobot dari user tiap kriteria dengan matrix R
            $matrix_v_k1 = [];
            $matrix_v_k2 = [];
            $matrix_v_k3 = [];
            $matrix_v_k4 = [];
            $matrix_v_k5 = [];
            $matrix_v_k6 = [];
            $matrix_v_k7 = [];
            // $matrix_v_k6 = [];
            foreach($book as $bk){
                $matrix_v_k1[$bk->id] = $matrix_r_k1[$bk->id] * $bobot_k1;
                $matrix_v_k2[$bk->id] = $matrix_r_k2[$bk->id] * $bobot_k2;
                $matrix_v_k3[$bk->id] = $matrix_r_k3[$bk->id] * $bobot_k3; 
                $matrix_v_k4[$bk->id] = $matrix_r_k4[$bk->id] * $bobot_k4;
                $matrix_v_k5[$bk->id] = $matrix_r_k5[$bk->id] * $bobot_k5;
                $matrix_v_k6[$bk->id] = $matrix_r_k6[$bk->id] * $bobot_k6;
                $matrix_v_k7[$bk->id] = $matrix_r_k7[$bk->id] * $bobot_k7;
            }

            // dd($matrix_v_k1, $matrix_v_k2, $matrix_v_k3, $matrix_v_k4, $matrix_v_k5, $matrix_v_k6, $matrix_v_k7);

            // ---------------------------------------------------- Menentukan A* dan A' ------------------------------------------------------
            // A* (Solusi ideal positif) tiap kriteria
            // K1 -> Benefit (MAX), K2 -> Cost (MIN), K3 -> Benefit (MAX), K4 -> Cost (MIN), K5 -> Benefit(MAX)
            $solusi_ideal_positif_1 = max($matrix_v_k1);
            $solusi_ideal_positif_2 = min($matrix_v_k2);
            $solusi_ideal_positif_3 = max($matrix_v_k3);
            $solusi_ideal_positif_4 = min($matrix_v_k4);
            $solusi_ideal_positif_5 = max($matrix_v_k5);
            $solusi_ideal_positif_6 = max($matrix_v_k6);
            $solusi_ideal_positif_7 = max($matrix_v_k7);

            // A' (Solusi ideal negatif) tiap kriteria
            // K1 -> Benefit (MIN), K2 -> Cost (MAX), K3 -> Benefit (MIN), K4 -> Cost (MAX), K5 -> Benefit (MIN)
            $solusi_ideal_negatif_1 = min($matrix_v_k1);
            $solusi_ideal_negatif_2 = max($matrix_v_k2);
            $solusi_ideal_negatif_3 = min($matrix_v_k3);
            $solusi_ideal_negatif_4 = max($matrix_v_k4);
            $solusi_ideal_negatif_5 = min($matrix_v_k5);
            $solusi_ideal_negatif_6 = min($matrix_v_k6);
            $solusi_ideal_negatif_7 = min($matrix_v_k7);

            // dd($solusi_ideal_positif_1, $solusi_ideal_positif_2, $solusi_ideal_positif_3, $solusi_ideal_positif_4, $solusi_ideal_positif_5, $solusi_ideal_positif_6, $solusi_ideal_positif_7);
            // dd($solusi_ideal_negatif_1, $solusi_ideal_negatif_2, $solusi_ideal_negatif_3, $solusi_ideal_negatif_4, $solusi_ideal_negatif_5, $solusi_ideal_negatif_6);

            // ---------------------------------------------------- Menentukan S* dan S' ------------------------------------------------------
            // S* (Jarak Solusi ideal positif) tiap kriteria
            $arr_jarak_solusi_ideal_positif_1 = [];
            $arr_jarak_solusi_ideal_positif_2 = [];
            $arr_jarak_solusi_ideal_positif_3 = [];
            $arr_jarak_solusi_ideal_positif_4 = [];
            $arr_jarak_solusi_ideal_positif_5 = [];
            $arr_jarak_solusi_ideal_positif_6 = [];
            $arr_jarak_solusi_ideal_positif_7 = [];

            $jarak_solusi_ideal_positif = [];
            foreach($book as $bk){
                $arr_jarak_solusi_ideal_positif_1[$bk->id] = ($matrix_v_k1[$bk->id]-$solusi_ideal_positif_1)*($matrix_v_k1[$bk->id]-$solusi_ideal_positif_1);
                $arr_jarak_solusi_ideal_positif_2[$bk->id] = ($matrix_v_k2[$bk->id]-$solusi_ideal_positif_2)*($matrix_v_k2[$bk->id]-$solusi_ideal_positif_2);
                $arr_jarak_solusi_ideal_positif_3[$bk->id] = ($matrix_v_k3[$bk->id]-$solusi_ideal_positif_3)*($matrix_v_k3[$bk->id]-$solusi_ideal_positif_3); 
                $arr_jarak_solusi_ideal_positif_4[$bk->id] = ($matrix_v_k4[$bk->id]-$solusi_ideal_positif_4)*($matrix_v_k4[$bk->id]-$solusi_ideal_positif_4);
                $arr_jarak_solusi_ideal_positif_5[$bk->id] = ($matrix_v_k5[$bk->id]-$solusi_ideal_positif_5)*($matrix_v_k5[$bk->id]-$solusi_ideal_positif_5);
                $arr_jarak_solusi_ideal_positif_6[$bk->id] = ($matrix_v_k6[$bk->id]-$solusi_ideal_positif_6)*($matrix_v_k6[$bk->id]-$solusi_ideal_positif_6);
                $arr_jarak_solusi_ideal_positif_7[$bk->id] = ($matrix_v_k7[$bk->id]-$solusi_ideal_positif_7)*($matrix_v_k7[$bk->id]-$solusi_ideal_positif_7);
            }
            // dd($arr_jarak_solusi_ideal_positif_1, $arr_jarak_solusi_ideal_positif_2, $arr_jarak_solusi_ideal_positif_3, $arr_jarak_solusi_ideal_positif_4, $arr_jarak_solusi_ideal_positif_5, $arr_jarak_solusi_ideal_positif_6);

            // jumlah smua kriteria tiap buku lalu diakar
            foreach($book as $bk){
                $count = $arr_jarak_solusi_ideal_positif_1[$bk->id] + $arr_jarak_solusi_ideal_positif_2[$bk->id] + $arr_jarak_solusi_ideal_positif_3[$bk->id] + $arr_jarak_solusi_ideal_positif_4[$bk->id] + $arr_jarak_solusi_ideal_positif_5[$bk->id] + $arr_jarak_solusi_ideal_positif_6[$bk->id] + $arr_jarak_solusi_ideal_positif_7[$bk->id];

                $jarak_solusi_ideal_positif[$bk->id] = sqrt($count);
            }

            // dd($jarak_solusi_ideal_positif);

            // S' (Jarak Solusi ideal negatif) tiap kriteria
            $arr_jarak_solusi_ideal_negatif_1 = [];
            $arr_jarak_solusi_ideal_negatif_2 = [];
            $arr_jarak_solusi_ideal_negatif_3 = [];
            $arr_jarak_solusi_ideal_negatif_4 = [];
            $arr_jarak_solusi_ideal_negatif_5 = [];
            $arr_jarak_solusi_ideal_negatif_6 = [];
            $arr_jarak_solusi_ideal_negatif_7 = [];

            $jarak_solusi_ideal_negatif = [];
            foreach($book as $bk){
                $arr_jarak_solusi_ideal_negatif_1[$bk->id] = ($matrix_v_k1[$bk->id]-$solusi_ideal_negatif_1)*($matrix_v_k1[$bk->id]-$solusi_ideal_negatif_1);
                $arr_jarak_solusi_ideal_negatif_2[$bk->id] = ($matrix_v_k2[$bk->id]-$solusi_ideal_negatif_2)*($matrix_v_k2[$bk->id]-$solusi_ideal_negatif_2);
                $arr_jarak_solusi_ideal_negatif_3[$bk->id] = ($matrix_v_k3[$bk->id]-$solusi_ideal_negatif_3)*($matrix_v_k3[$bk->id]-$solusi_ideal_negatif_3); 
                $arr_jarak_solusi_ideal_negatif_4[$bk->id] = ($matrix_v_k4[$bk->id]-$solusi_ideal_negatif_4)*($matrix_v_k4[$bk->id]-$solusi_ideal_negatif_4);
                $arr_jarak_solusi_ideal_negatif_5[$bk->id] = ($matrix_v_k5[$bk->id]-$solusi_ideal_negatif_5)*($matrix_v_k5[$bk->id]-$solusi_ideal_negatif_5);
                $arr_jarak_solusi_ideal_negatif_6[$bk->id] = ($matrix_v_k6[$bk->id]-$solusi_ideal_negatif_6)*($matrix_v_k6[$bk->id]-$solusi_ideal_negatif_6);
                $arr_jarak_solusi_ideal_negatif_7[$bk->id] = ($matrix_v_k7[$bk->id]-$solusi_ideal_negatif_7)*($matrix_v_k7[$bk->id]-$solusi_ideal_negatif_7);
            }

            // dd($arr_jarak_solusi_ideal_negatif_1, $arr_jarak_solusi_ideal_negatif_2, $arr_jarak_solusi_ideal_negatif_3, $arr_jarak_solusi_ideal_negatif_4, $arr_jarak_solusi_ideal_negatif_5, $arr_jarak_solusi_ideal_negatif_6);

            // jumlah smua kriteria tiap buku lalu diakar
            foreach($book as $bk){
                $count = $arr_jarak_solusi_ideal_negatif_1[$bk->id] + $arr_jarak_solusi_ideal_negatif_2[$bk->id] + $arr_jarak_solusi_ideal_negatif_3[$bk->id] + $arr_jarak_solusi_ideal_negatif_4[$bk->id] + $arr_jarak_solusi_ideal_negatif_5[$bk->id] + $arr_jarak_solusi_ideal_negatif_6[$bk->id] + $arr_jarak_solusi_ideal_negatif_7[$bk->id];

                $jarak_solusi_ideal_negatif[$bk->id] = sqrt($count);
            }

            // dd($jarak_solusi_ideal_negatif);

            // ---------------------------------------- menghitung kedekatan relatif (C) tiap buku -------------------------------------------
            $arr_kedekatan_relatif = [];
            foreach($book as $bk){
                $arr_kedekatan_relatif[$bk->id] = $jarak_solusi_ideal_negatif[$bk->id]/($jarak_solusi_ideal_positif[$bk->id] + $jarak_solusi_ideal_negatif[$bk->id]);
            }

            // dd($arr_kedekatan_relatif);

            // -------------------------------- Urutkan C dari terbesar/yang paling dekat dengan 1 ------------------------------------
            $arr_topsis = []; 
            $arr_topsis = collect($arr_kedekatan_relatif);
            $arr_topsis = $arr_topsis->sortDesc();
            $arr_topsis->values()->all();
            // dd($arr_topsis);

            // Simpan data buku sesuai urutas hasil TOPSIS lalu kirim ke view untuk ditampilkan
            $data = [];
            $i = 0;
            foreach($arr_topsis as $key => $val){
                $data[$i] = DB::table('biblios')->select('id','title', 'image')->where('id','=', $key)->get();
                $i++;
            }

            // dd($arr_topsis[16]);
            // dd($data);
            return view('frontend.recommendation', compact('data','arr_topsis'));
            // return view('frontend.recommendation', compact('data','book','arr_count_borrow', 'arr_count_page', 'arr_author', 'arr_age', 'arr_stock', 'pow_count_borrow', 'pow_count_page','pow_author','pow_age','pow_stock','k1','k2','k3','k4','k5','sqrt_k1','sqrt_k2','sqrt_k3','sqrt_k4','sqrt_k5','matrix_r_k1','matrix_r_k2','matrix_r_k3','matrix_r_k4','matrix_r_k5','bobot_k1','bobot_k2','bobot_k3','bobot_k4','bobot_k5','matrix_v_k1','matrix_v_k2','matrix_v_k3','matrix_v_k4','matrix_v_k5','solusi_ideal_positif_1','solusi_ideal_positif_2','solusi_ideal_positif_3','solusi_ideal_positif_4','solusi_ideal_positif_5','solusi_ideal_negatif_1','solusi_ideal_negatif_2','solusi_ideal_negatif_3','solusi_ideal_negatif_4','solusi_ideal_negatif_5','arr_jarak_solusi_ideal_positif_1','arr_jarak_solusi_ideal_positif_2','arr_jarak_solusi_ideal_positif_3','arr_jarak_solusi_ideal_positif_4','arr_jarak_solusi_ideal_positif_5','jarak_solusi_ideal_positif','arr_jarak_solusi_ideal_negatif_1','arr_jarak_solusi_ideal_negatif_2','arr_jarak_solusi_ideal_negatif_3','arr_jarak_solusi_ideal_negatif_4','arr_jarak_solusi_ideal_negatif_5','jarak_solusi_ideal_negatif','arr_topsis'));
        }
    }
}
