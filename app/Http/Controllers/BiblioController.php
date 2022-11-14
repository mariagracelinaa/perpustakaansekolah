<?php

namespace App\Http\Controllers;

use App\Biblio;
use App\Publisher;
use App\Deletion;
use App\Item;
use App\Author;
use Illuminate\Http\Request;
use DB;
use File;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

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
        return view('biblio.index', compact('result', 'publisher', 'author'));
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
        // dd($request);
        $validator = \Validator::make($request->all(), [
            'title' => 'required',
            'isbn' => 'required',
            'listPublisher' => 'required',
            'listAuthor' => 'required',
            'publish_year' => 'required',
            'first_purchase' => 'required',
            'ddc' => 'required',
            'classification' => 'required',
            'edition' => 'required',
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
            'ddc.required' => 'Kategori DDC tidak boleh kosong',
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
                $biblio->ddc = $request->get('ddc');
                $biblio->classification = $request->get('classification');
                
                $ext = $request->file('image')->extension();
                $file = $request->file('image');
                $imgFolder = 'images';
                // $imgFile = $file->getClientOriginalName();
                $imgFile = $request->get('title').'.'.$ext;
                $file->move($imgFolder, $imgFile);
                $biblio->image = $imgFile;

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

        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('biblio.getEditForm', compact('data','author_data','publisher','author'))->render()
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
            'ddc' => 'required',
            'classification' => 'required',
            'edition' => 'required',
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
            'ddc.required' => 'Kategori DDC tidak boleh kosong',
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
                $ddc = $request->get('ddc');
                $classification = $request->get('classification');
                
                // Hapus foto lama terlebih dahulu 
                // dd($old_image[0]->image);
                // Storage::delete();
                File::delete(public_path('images/'.$old_image[0]->image));

                // Simpan foto baru
                // $file = $request->file('image');
                // $imgFolder = 'images';
                // $imgFile = $request->file('image')->getClientOriginalName();
                // $file->move($imgFolder, $imgFile);
                // $image = $imgFile;

                $ext = $request->file('image')->extension();
                $file = $request->file('image');
                $imgFolder = 'images';
                // $imgFile = $file->getClientOriginalName();
                $imgFile = $title.'.'.$ext;
                $file->move($imgFolder, $imgFile);
                $image = $imgFile;

                $edition = $request->get('edition');
                $page = $request->get('page');
                $book_height = $request->get('height');
                $location = $request->get('location');
                $synopsis = $request->get('synopsis');

                // dd($title, $isbn , $publish_year, $publishers_id, $first_purchase, $ddc, $classification, $image, $edition, $page, $book_height, $location);

                $data = DB::table('biblios')
                        ->where('id', $request->get('id'))
                        ->update(['title' => $title, 'isbn' => $isbn, 'publishers_id' => $publishers_id,'publish_year' => $publish_year, 'first_purchase' => $first_purchase, 'ddc' => $ddc, 'classification' => $classification, 'image' => $image, 'edition' => $edition, 'page' => $page, 'book_height' => $book_height, 'location' => $location, 'synopsis' => $synopsis]);

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
        $start = "";
        $end = "";
        $data = DB::table('bookings')
                ->join('biblios', 'biblios.id','=','bookings.biblios_id')
                ->join('users','users.id','=','bookings.users_id')
                ->select('users.name', 'biblios.title', 'bookings.booking_date','bookings.description')
                ->orderBy('booking_date','ASC')
                ->get();
        // dd($data);
        return view('booking.index', compact('data', 'start', 'end'));
    }

    public function bookingList_filter(Request $request){
        $this->authorize('check-admin');
        $start = $request->get('date_start');
        $end = $request->get('date_end');
        $data = DB::table('bookings')
                ->join('biblios', 'biblios.id','=','bookings.biblios_id')
                ->join('users','users.id','=','bookings.users_id')
                ->select('users.name', 'biblios.title', DB::raw('DATE_FORMAT(bookings.booking_date, "%d-%m-%Y") as booking_date'),'bookings.description')
                ->whereBetween('booking_date', [$start, $end])
                ->orderBy('booking_date','ASC')
                ->get();
        return view('booking.index', compact('data', 'start', 'end'));
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
        return view('frontend.detail', compact('data','items', 'author_name','count'));
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
        try{
            DB::table('bookings')->insert(
                ['biblios_id' => $request->get('biblios_id') , 'users_id' => $request->get('id'), 'description' => $request->get('desc')]
            );

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
                ->select('biblios.id','biblios.title', 'bookings.booking_date','bookings.description')
                ->where('users_id','=',$id)
                ->orderBy('booking_date','ASC')
                ->get();
        return view('frontend.myBooking', compact('data'));
    }

    public function deleteMyBooking(Request $request){
        $this->authorize('check-user');
        $users_id = $request->get('id');
        $biblios_id = $request->get('biblios_id');
        // dd($users_id, $biblios_id);

        try{
            DB::table('bookings')->where('users_id', '=', $users_id)->where('biblios_id','=',$biblios_id)->delete();
            return session()->flash('status','Berhasil menghapus pemesanan buku');
        }catch (\PDOException $e) {
            return session()->flash('error', 'Gagal menghapus pemesanan buku, silahkan coba lagi');
        }
        
    }

    public function formTopsis(){
        $author = Author::all();
        return view('frontend.formTopsis',compact('author'));
    }

    public function topsis(Request $request){
        // dd($request->get('category'), $request->get('radio_borrow'),$request->get('radio_page'),$request->get('radio_publish'), $request->get('radio_age'));

        if($request->get('category') == 1000){
            return redirect()->back()->with('error', 'Kategori buku tidak boleh kosong, pilih salah satu kategori buku yang diinginkan');
        }else{
            // Bobot dari user
            $bobot_k1 = $request->get('radio_borrow');
            $bobot_k2 = $request->get('radio_page');
            $bobot_k3 = $request->get('radio_publish');
            $bobot_k4 = $request->get('radio_age');
            $bobot_k5 = $request->get('radio_stock');

            // $bobot_k1 = 4;
            // $bobot_k2 = 4;
            // $bobot_k3 = 5;
            // $bobot_k4 = 3;
            // $bobot_k5 = 5;
            // bobot x -> kesesuaian penulis, kalo ada isinya cocok kasih 5. kalo gaada isi/ga cocok kasih 3

            // bobot 5 -> stok buku diperpustakaan, jika stok ada kasih 5, jika kosong kasih 1
            

            // Query untuk ambil data buku dari db sesuai kategori DDC user
            $book = DB::table('biblios')
                    ->select()
                    ->where('ddc','=',$request->get('category'))
                    ->get();
            // dd($book);
            
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

            // Query tahun terbit buku -> K3
            $arr_publish_year = [];
            foreach($book as $bk){
                // dd($bk->id);
                $publish_year = DB::table('biblios')
                                ->select('biblios.publish_year')
                                ->where('biblios.id','=', $bk->id)
                                ->get();
                $arr_publish_year[$bk->id] = $publish_year[0];
            }
            // dd($arr_publish_year);

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

            // ---------------------------------------------------- Matrix R ------------------------------------------------------
            // Setiap decision matrix dipangkat 2
            $pow_count_borrow = [];
            $pow_count_page = [];
            $pow_publish_year = [];
            $pow_age = [];
            $pow_stock = [];
            foreach($book as $bk){
                $pow_count_borrow[$bk->id] = $arr_count_borrow[$bk->id]->count * $arr_count_borrow[$bk->id]->count;
                $pow_count_page[$bk->id] = $arr_count_page[$bk->id]->page * $arr_count_page[$bk->id]->page;
                $pow_publish_year[$bk->id] = $arr_publish_year[$bk->id]->publish_year * $arr_publish_year[$bk->id]->publish_year;
                $pow_age[$bk->id] = $arr_age[$bk->id]->age * $arr_age[$bk->id]->age;
                $pow_stock[$bk->id] = $arr_stock[$bk->id]->stock * $arr_stock[$bk->id]->stock;
            }
            // dd($pow_stock);

            //Total semua nilai buku disetiap kriteria
            $k1 = 0;
            $k2 = 0;
            $k3 = 0;
            $k4 = 0;
            $k5 = 0;

            foreach($pow_count_borrow as $acb){
                $k1 = $k1 + $acb;
            }
            
            foreach($pow_count_page as $acp){
                $k2 = $k2 + $acp;
            }

            foreach($pow_publish_year as $apy){
                $k3 = $k3 + $apy;
            }

            foreach($pow_age as $aa){
                $k4 = $k4 + $aa;
            }

            foreach($pow_stock as $as){
                $k5 = $k5 + $as;
            }

            // Akar total dari tiap kriteria yang ada
            $sqrt_k1 = sqrt($k1);
            $sqrt_k2 = sqrt($k2);
            $sqrt_k3 = sqrt($k3);
            $sqrt_k4 = sqrt($k4);
            $sqrt_k5 = sqrt($k5);

            // dd($sqrt_k1, $sqrt_k2, $sqrt_k3, $sqrt_k4, $sqrt_k5);

            // Bagi nilai awal matrix dengan hasil akar
            $matrix_r_k1 = [];
            $matrix_r_k2 = [];
            $matrix_r_k3 = [];
            $matrix_r_k4 = [];
            $matrix_r_k5 = [];
            foreach($book as $bk){
                $matrix_r_k1[$bk->id] = $arr_count_borrow[$bk->id]->count / $sqrt_k1;
                $matrix_r_k2[$bk->id] = $arr_count_page[$bk->id]->page / $sqrt_k2;
                $matrix_r_k3[$bk->id] = $arr_publish_year[$bk->id]->publish_year / $sqrt_k3;
                $matrix_r_k4[$bk->id] = $arr_age[$bk->id]->age / $sqrt_k4;
                $matrix_r_k5[$bk->id] = $arr_stock[$bk->id]->stock / $sqrt_k5;
            }

            // dd($matrix_r_k1, $matrix_r_k2, $matrix_r_k3 , $matrix_r_k4, $matrix_r_k5);

            // ---------------------------------------------------- Matrix V ------------------------------------------------------
            // Kalikan bobot dari user tiap kriteria dengan matrix R
            $matrix_v_k1 = [];
            $matrix_v_k2 = [];
            $matrix_v_k3 = [];
            $matrix_v_k4 = [];
            $matrix_v_k5 = [];
            foreach($book as $bk){
                $matrix_v_k1[$bk->id] = $matrix_r_k1[$bk->id] * $bobot_k1;
                $matrix_v_k2[$bk->id] = $matrix_r_k2[$bk->id] * $bobot_k2;
                $matrix_v_k3[$bk->id] = $matrix_r_k3[$bk->id] * $bobot_k3; 
                $matrix_v_k4[$bk->id] = $matrix_r_k4[$bk->id] * $bobot_k4;
                $matrix_v_k5[$bk->id] = $matrix_r_k5[$bk->id] * $bobot_k5;
            }

            // dd($matrix_v_k1, $matrix_v_k2, $matrix_v_k3, $matrix_v_k4, $matrix_v_k5);

            // ---------------------------------------------------- Menentukan A* dan A' ------------------------------------------------------
            // A* (Solusi ideal positif) tiap kriteria
            // K1 -> Benefit (MAX), K2 -> Cost (MIN), K3 -> Benefit (MAX), K4 -> Cost (MIN), K5 -> Benefit(MAX)
            $solusi_ideal_positif_1 = max($matrix_v_k1);
            $solusi_ideal_positif_2 = min($matrix_v_k2);
            $solusi_ideal_positif_3 = max($matrix_v_k3);
            $solusi_ideal_positif_4 = min($matrix_v_k4);
            $solusi_ideal_positif_5 = max($matrix_v_k5);

            // A' (Solusi ideal negatif) tiap kriteria
            // K1 -> Benefit (MIN), K2 -> Cost (MAX), K3 -> Benefit (MIN), K4 -> Cost (MAX), K5 -> Benefit (MIN)
            $solusi_ideal_negatif_1 = min($matrix_v_k1);
            $solusi_ideal_negatif_2 = max($matrix_v_k2);
            $solusi_ideal_negatif_3 = min($matrix_v_k3);
            $solusi_ideal_negatif_4 = max($matrix_v_k4);
            $solusi_ideal_negatif_5 = min($matrix_v_k5);

            // dd($solusi_ideal_positif_1, $solusi_ideal_positif_2, $solusi_ideal_positif_3, $solusi_ideal_positif_4, $solusi_ideal_positif_5);
            // dd($solusi_ideal_negatif_1, $solusi_ideal_negatif_2, $solusi_ideal_negatif_3, $solusi_ideal_negatif_4, $solusi_ideal_negatif_5);

            // ---------------------------------------------------- Menentukan S* dan S' ------------------------------------------------------
            // S* (Jarak Solusi ideal positif) tiap kriteria
            $arr_jarak_solusi_ideal_positif_1 = [];
            $arr_jarak_solusi_ideal_positif_2 = [];
            $arr_jarak_solusi_ideal_positif_3 = [];
            $arr_jarak_solusi_ideal_positif_4 = [];
            $arr_jarak_solusi_ideal_positif_5 = [];
            $jarak_solusi_ideal_positif = [];
            foreach($book as $bk){
                $arr_jarak_solusi_ideal_positif_1[$bk->id] = ($matrix_v_k1[$bk->id]-$solusi_ideal_positif_1)*($matrix_v_k1[$bk->id]-$solusi_ideal_positif_1);
                $arr_jarak_solusi_ideal_positif_2[$bk->id] = ($matrix_v_k2[$bk->id]-$solusi_ideal_positif_2)*($matrix_v_k2[$bk->id]-$solusi_ideal_positif_2);
                $arr_jarak_solusi_ideal_positif_3[$bk->id] = ($matrix_v_k3[$bk->id]-$solusi_ideal_positif_3)*($matrix_v_k3[$bk->id]-$solusi_ideal_positif_3); 
                $arr_jarak_solusi_ideal_positif_4[$bk->id] = ($matrix_v_k4[$bk->id]-$solusi_ideal_positif_4)*($matrix_v_k4[$bk->id]-$solusi_ideal_positif_4);
                $arr_jarak_solusi_ideal_positif_5[$bk->id] = ($matrix_v_k5[$bk->id]-$solusi_ideal_positif_5)*($matrix_v_k5[$bk->id]-$solusi_ideal_positif_5);
            }
            // dd($arr_jarak_solusi_ideal_positif_1, $arr_jarak_solusi_ideal_positif_2, $arr_jarak_solusi_ideal_positif_3, $arr_jarak_solusi_ideal_positif_4, $arr_jarak_solusi_ideal_positif_5);

            // jumlah smua kriteria tiap buku lalu diakar
            foreach($book as $bk){
                $count = $arr_jarak_solusi_ideal_positif_1[$bk->id] + $arr_jarak_solusi_ideal_positif_2[$bk->id] + $arr_jarak_solusi_ideal_positif_3[$bk->id] + $arr_jarak_solusi_ideal_positif_4[$bk->id] + $arr_jarak_solusi_ideal_positif_5[$bk->id];

                $jarak_solusi_ideal_positif[$bk->id] = sqrt($count);
            }

            // dd($jarak_solusi_ideal_positif);

            // S' (Jarak Solusi ideal negatif) tiap kriteria
            $arr_jarak_solusi_ideal_negatif_1 = [];
            $arr_jarak_solusi_ideal_negatif_2 = [];
            $arr_jarak_solusi_ideal_negatif_3 = [];
            $arr_jarak_solusi_ideal_negatif_4 = [];
            $arr_jarak_solusi_ideal_negatif_5 = [];
            $jarak_solusi_ideal_negatif = [];
            foreach($book as $bk){
                $arr_jarak_solusi_ideal_negatif_1[$bk->id] = ($matrix_v_k1[$bk->id]-$solusi_ideal_negatif_1)*($matrix_v_k1[$bk->id]-$solusi_ideal_negatif_1);
                $arr_jarak_solusi_ideal_negatif_2[$bk->id] = ($matrix_v_k2[$bk->id]-$solusi_ideal_negatif_2)*($matrix_v_k2[$bk->id]-$solusi_ideal_negatif_2);
                $arr_jarak_solusi_ideal_negatif_3[$bk->id] = ($matrix_v_k3[$bk->id]-$solusi_ideal_negatif_3)*($matrix_v_k3[$bk->id]-$solusi_ideal_negatif_3); 
                $arr_jarak_solusi_ideal_negatif_4[$bk->id] = ($matrix_v_k4[$bk->id]-$solusi_ideal_negatif_4)*($matrix_v_k4[$bk->id]-$solusi_ideal_negatif_4);
                $arr_jarak_solusi_ideal_negatif_5[$bk->id] = ($matrix_v_k5[$bk->id]-$solusi_ideal_negatif_5)*($matrix_v_k5[$bk->id]-$solusi_ideal_negatif_5);
            }

            // dd($arr_jarak_solusi_ideal_negatif_1, $arr_jarak_solusi_ideal_negatif_2, $arr_jarak_solusi_ideal_negatif_3, $arr_jarak_solusi_ideal_negatif_4, $arr_jarak_solusi_ideal_negatif_5);

            // jumlah smua kriteria tiap buku lalu diakar
            foreach($book as $bk){
                $count = $arr_jarak_solusi_ideal_negatif_1[$bk->id] + $arr_jarak_solusi_ideal_negatif_2[$bk->id] + $arr_jarak_solusi_ideal_negatif_3[$bk->id] + $arr_jarak_solusi_ideal_negatif_4[$bk->id] + $arr_jarak_solusi_ideal_negatif_5[$bk->id];

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

            // dd($data);
            return view('frontend.recommendation', compact('data','book','arr_count_borrow', 'arr_count_page', 'arr_publish_year', 'arr_age', 'arr_stock', 'pow_count_borrow', 'pow_count_page','pow_publish_year','pow_age','pow_stock','k1','k2','k3','k4','k5','sqrt_k1','sqrt_k2','sqrt_k3','sqrt_k4','sqrt_k5','matrix_r_k1','matrix_r_k2','matrix_r_k3','matrix_r_k4','matrix_r_k5','bobot_k1','bobot_k2','bobot_k3','bobot_k4','bobot_k5','matrix_v_k1','matrix_v_k2','matrix_v_k3','matrix_v_k4','matrix_v_k5','solusi_ideal_positif_1','solusi_ideal_positif_2','solusi_ideal_positif_3','solusi_ideal_positif_4','solusi_ideal_positif_5','solusi_ideal_negatif_1','solusi_ideal_negatif_2','solusi_ideal_negatif_3','solusi_ideal_negatif_4','solusi_ideal_negatif_5','arr_jarak_solusi_ideal_positif_1','arr_jarak_solusi_ideal_positif_2','arr_jarak_solusi_ideal_positif_3','arr_jarak_solusi_ideal_positif_4','arr_jarak_solusi_ideal_positif_5','jarak_solusi_ideal_positif','arr_jarak_solusi_ideal_negatif_1','arr_jarak_solusi_ideal_negatif_2','arr_jarak_solusi_ideal_negatif_3','arr_jarak_solusi_ideal_negatif_4','arr_jarak_solusi_ideal_negatif_5','jarak_solusi_ideal_negatif','arr_topsis'));
        }
    }

    // public function getCheckTopsis(Request $request){
    //     $arr_count_borrow = $request->get('borrow');
    //     $arr_count_page = $request->get('age');
    //     $arr_publish_year = $request->get('publish_year');
    //     $arr_age = $request->get('age');
    //     $arr_stock = $request->get('stock');

    //     return view('frontend.check_topsis', compact('arr_count_borrow', 'arr_count_page', 'arr_publish_year', 'arr_age', 'arr_stock'));
    // }
}
