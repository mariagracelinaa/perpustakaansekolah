<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Biblio;
use App\Author;
use App\Publisher;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    //  Menampilkan semua daftar buku di frontend
    public function index()
    {
        $data = Biblio::select()->orderBy('id','desc')->get();
        return view('frontend.allbook', compact('data'));
    }

    public function index_filter(Request $request)
    {
        if($request == null){
            $data = Biblio::select()->orderBy('id','desc')->get();
        }else{
            $data = DB::table('biblios')
                ->where('title', 'like', '%'.$request->get('search').'%')
                ->orderBy('id','desc')
                ->get();
        }
        // dd($data);
        // return view('frontend.allbook', compact('data'));
        return response()->json(array('data' => $data));
    }

    // public function index_filter_cathegory(Request $request)
    // {
    //     if( $request->get('ddc') != null &&  $request->get('search') != null){
    //         $data = DB::table('biblios')
    //             ->where('ddc','=', $request->get('ddc'))
    //             ->where('title', 'like', '%'.$request->get('search').'%')
    //             ->orderBy('id','desc')
    //             ->get();
    //     }else{
    //         $data = DB::table('biblios')
    //             ->select()
    //             ->where('ddc','=',  $request->get('ddc'))
    //             ->orderBy('id','desc')
    //             ->get();
    //     }
    //     // dd($request->get('ddc'));
    //     // return view('frontend.allbook', compact('data'));
    //     return response()->json(array('data' => $data));
    // }

    public function book_cathegory($ddc){
        if( $ddc == 0){
            $ddc = '000';
        }
        
        $data = DB::table('biblios')
                ->select()
                ->where('ddc','=', $ddc)
                ->orderBy('id','desc')
                ->get();

        // dd($data);
        return view('frontend.cathegory_book', compact('data'));
    }
}
