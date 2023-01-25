<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;

use DB;
use Auth;

use Carbon\Carbon;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-admin');
        $result = Author::all();
        return view('author.index', compact('result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ],
        [
            'name.required' => 'Nama penulis tidak boleh kosong',
        ]);
        
        if (!$validator->passes())
        {
            return response()->json(['status'=>0, 'errors'=>$validator->errors()->toArray()]);
        }else{
            try{
                $data = new Author();
                $data->name = $request->get('name');
                $data->save();
                $request->session()->flash('status','Data penulis baru berhasil disimpan');
            }catch (\PDOException $e) {
                $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function edit(Author $author)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Author $author)
    {
        // try{
        //     $author->name = $request->get('name');
            // $author->save();
            // dd($author);
            // return redirect()->route('daftar-penerbit.index')->with('status', 'Data penerbit berhasil diubah');
        // }catch (\PDOException $e) {
        //     return redirect()->route('daftar-penulis.index')->with('error', 'Data penulis gagal diubah, silahkan coba lagi');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        //
    }

    public function getEditForm(Request $request){
        $id = $request->get('id');
        $data = Author::find($id);
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('author.getEditForm', compact('data'))->render()
        ), 200);
    }

    public function updateData(Request $request){
        $this->authorize('check-admin');
        // dd($request->get('eName'));
        $validator = \Validator::make($request->all(), [
            'eName' => 'required',
        ],
        [
            'eName.required' => 'Nama penulis tidak boleh kosong',
        ]);
        
        if (!$validator->passes())
        {
            return response()->json(['status'=>0, 'errors'=>$validator->errors()->toArray()]);
        }else{
            $id = $request->get('id');
            $name = $request->get('eName');
            try{
                $data = DB::table('authors')
                        ->where('id', $id)
                        ->update(['name' => $name]);
                        
                $request->session()->flash('status','Data penulis berhasil diubah');
            }catch (\PDOException $e) {
                $request->session()->flash('error', 'Gagal mengubah data penulis, silahkan coba lagi');
            }  
        }
    }

    // Isi combobox author di form TOPSIS berdasarkan 
    public function cb_box_author(Request $request){
        $cat = $request->get('cat');
        if($cat == 000 || $cat == 100 || $cat == 200 || $cat == 300 || $cat == 400 || $cat == 500 || $cat == 600 || $cat == 700 || $cat == 800 || $cat == 900){
            $data = DB::table('authors')
                        ->join('authors_biblios','authors.id','=','authors_biblios.authors_id')
                        ->join('biblios','biblios.id','=','authors_biblios.biblios_id')
                        ->join('categories','categories.id','=','biblios.categories_id')
                        ->select(DB::raw('DISTINCT(authors.id), authors.name'))
                        ->where('categories.ddc','=',$cat)
                        ->orderBy('authors.name','asc')
                        ->get();
        }else{
            $data = DB::table('authors')
                        ->join('authors_biblios','authors.id','=','authors_biblios.authors_id')
                        ->join('biblios','biblios.id','=','authors_biblios.biblios_id')
                        ->join('categories','categories.id','=','biblios.categories_id')
                        ->select(DB::raw('DISTINCT(authors.id), authors.name'))
                        ->where('categories.id','=',$cat)
                        ->orderBy('authors.name','asc')
                        ->get();
        }
        
        return response()->json(array('data' => $data));
    }

    public function authorList(){
        $author = Author::all();
        // $data = [];
        // for($i = 0; $i < count($author); $i++){
        //     $count = DB::table('authors')
        //         ->join('authors_biblios','authors.id','=','authors_biblios.authors_id')
        //         ->select('authors.id','authors.name', DB::raw('COUNT(*) as jumlah_koleksi'))
        //         ->where('authors_id','=', $author[$i]->id)
        //         ->groupBy('authors.id')
        //         ->groupBy('authors.name')
        //         ->get();
        //     // dd($count[0]);
        //     $data[] = $count;
        // }
        // dd($data);
        return view('frontend.authors', compact('author'));
    }

    public function detail_author($authors_id){
        $author = DB::table('authors')
                    ->select()
                    ->where('authors.id','=', $authors_id)
                    ->get();

        $list_book = DB::table('biblios')
                    ->join('authors_biblios','biblios.id','=','authors_biblios.biblios_id')
                    ->select('biblios.*')
                    ->where('authors_biblios.authors_id','=', $authors_id)
                    ->get();
        // hitung rating penulis
        // total rating x jumlah
        $total_author_rating = 0;
        for ($i=1; $i <= 5; $i++) { 
            $cr = DB::table('author_ratings')
                    ->select(DB::raw('COUNT(*) as count'))
                    ->where('rate','=',$i)
                    ->where('authors_id','=',$authors_id)
                    ->get();
            
            $total_author_rating = $total_author_rating + ($i * $cr[0]->count);
        }
        // dd($total_author_rating);
        // Dapatkan nilai rating range 1-5
        $cs = DB::table('author_ratings')
                ->select(DB::raw('COUNT(*) as authorRate'))
                ->where('authors_id','=',$authors_id)
                ->get();

        if($cs[0]->authorRate == 0){
            $rating = 0;
        }else{
            $rating = $total_author_rating / $cs[0]->authorRate; 
        }

        // Baca rating dari user tertentu
        $author_rating_user = NULL;
        if(Auth::user()){
            $author_rating_user = DB::table('author_ratings')
                                ->select()
                                ->where('authors_id','=', $authors_id)
                                ->where('users_id','=', Auth::user()->id)
                                ->get();
            if(!$author_rating_user->isEmpty()){
                $author_rating_user = $author_rating_user[0];
            }else{
                $author_rating_user = NULL;
            }
        }
        // dd($list_book);
        return view('frontend.author_book', compact('list_book','rating','author','author_rating_user'));
    }

    public function addRating(Request $request){
        $this->authorize('check-user');
        try{
            $authors_id = $request->get('authors_id');
            $users_id = $request->get('users_id');
            $author_rating = $request->get('author_rating');
            $date = Carbon::now();

            // cek apa sudah ada data review nya
            $rate = DB::table('author_ratings')
                    ->select()
                    ->where('authors_id','=', $authors_id)
                    ->where('users_id','=',$users_id)
                    ->get();
            if(!$rate->isEmpty()){
                DB::table('author_ratings')
                ->where('authors_id', $authors_id)
                ->where('users_id', $users_id)
                ->update(['rate' => $author_rating, 'date' => $date]);
            }else{
                DB::table('author_ratings')
                ->insert(['authors_id' => $authors_id, 'users_id' => $users_id, 'rate' => $author_rating, 'date' => $date]);
            }

            return redirect()->back()->with('status', 'Rating berhasil dicatat');
        }catch (\PDOException $e) {
            return redirect()->back()->with('error', 'Rating gagal dicatat, silahkan coba lagi!');
        }
    }

}
