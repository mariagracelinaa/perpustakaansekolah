<?php

namespace App\Http\Controllers;

use App\Biblio;
use App\Publisher;
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

            // Save ke biblio
            $biblio = new Biblio();
            $biblio->title = $request->get('title');
            $biblio->isbn = $request->get('isbn');
            $biblio->publishers_id = $pub_id[0]->id;
            $biblio->publish_year = $request->get('publish_year');
            $biblio->purchase_year = $request->get('purchase_year');
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
            $biblio->save();

            // Save ke authors_biblios
            for($j = 0; $j < count($arr_id); $j++){
                if($j == 0){
                    $auth_biblio = DB::table('authors_biblios')
                            ->insert(['authors_id' => $arr_id[$j], 'biblios_id' => $biblio->id, 'primary_author' => 1]);
                }else{
                    $auth_biblio = DB::table('authors_biblios')
                            ->insert(['authors_id' => $arr_id[$j], 'biblios_id' => $biblio->id, 'primary_author' => 0]);
                }        
            }

            // $request->session()->flash('daftar-buku.index')->with('status','Data buku baru berhasil disimpan');
            return redirect()->route('daftar-buku.index')->with('status','Data buku baru berhasil disimpan');;
        }catch (\PDOException $e) {
            $request->session()->flash('daftar-buku.index')->with('error', 'Gagal menambah data baru, silahkan coba lagi');
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
        //
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

        //Ambil semua item dari biblio yang dimaksud
        $items = $data->items;
        return view('biblio.detailbiblio', compact('data','items'));
    }
}
