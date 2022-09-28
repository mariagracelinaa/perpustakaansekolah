<?php

namespace App\Http\Controllers;

use App\Biblio;
use App\Publisher;
use App\Deletion;
use App\Item;
use App\Author;
use Illuminate\Http\Request;
use DB;

class BiblioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
                
                $file = $request->file('image');
                $imgFolder = 'images';
                $imgFile = $request->file('image')->getClientOriginalName();
                $file->move($imgFolder, $imgFile);
                $biblio->image = $imgFile;

                $biblio->edition = $request->get('edition');
                $biblio->page = $request->get('page');
                $biblio->book_height = $request->get('height');
                $biblio->location = $request->get('location');
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
                return redirect()->route('daftar-buku.index')->with('status','Data buku baru berhasil disimpan');
            }catch (\PDOException $e) {
                return redirect()->route('daftar-buku.index')->with('error', 'Gagal menambah data baru, silahkan coba lagi');
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
                
                $file = $request->file('image');
                $imgFolder = 'images';
                $imgFile = $request->file('image')->getClientOriginalName();
                $file->move($imgFolder, $imgFile);
                $image = $imgFile;

                $edition = $request->get('edition');
                $page = $request->get('page');
                $book_height = $request->get('height');
                $location = $request->get('location');

                // dd($title, $isbn , $publish_year, $publishers_id, $first_purchase, $ddc, $classification, $image, $edition, $page, $book_height, $location);

                $data = DB::table('biblios')
                        ->where('id', $request->get('id'))
                        ->update(['title' => $title, 'isbn' => $isbn, 'publishers_id' => $publishers_id,'publish_year' => $publish_year, 'first_purchase' => $first_purchase, 'ddc' => $ddc, 'classification' => $classification, 'image' => $image, 'edition' => $edition, 'page' => $page, 'book_height' => $book_height, 'location' => $location]);

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

    // Laporan penghapusan buku (Tabel deletions)
    public function deletion(){
        $data = DB::table('deletions')
                ->join('items', 'items.register_num','=','deletions.register_num')
                ->join('biblios', 'items.biblios_id','=','biblios.id')
                ->select('deletions.*', 'biblios.title', 'items.source', 'items.price')
                ->get();
        // dd($data);
        return view('report.deleteReport', compact('data'));
    }

    // Cetak laporan penghapusan buku
    public function printDeleteReport(Request $request){
        $start = $request->get('start_date');
        $end = $request->get('end_date');
        
        $today = strftime('%d %B %Y');
        $data = DB::table('deletions')
                ->join('items', 'items.register_num','=','deletions.register_num')
                ->join('biblios', 'items.biblios_id','=','biblios.id')
                ->select('deletions.*', 'biblios.title', 'items.source', 'items.price')
                ->whereBetween('deletion_date', [$start,$end])
                ->get();
        // dd($data);
        $start = strftime('%d %B %Y', strtotime($start));
        $end = strftime('%d %B %Y', strtotime($end));
        return view('report.printDeleteReport', compact('data', 'start', 'end', 'today'));
    }

    public function bookingList(){
        $data = DB::table('bookings')
                ->join('biblios', 'biblios.id','=','bookings.biblios_id')
                ->join('users','users.id','=','bookings.users_id')
                ->select('users.name', 'biblios.title', 'bookings.booking_date')
                ->orderBy('booking_date','ASC')
                ->get();
        // dd($data);
        return view('booking.index', compact('data'));
    }
}
