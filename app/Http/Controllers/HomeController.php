<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Biblio;
use App\Author;
use App\Publisher;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
}
