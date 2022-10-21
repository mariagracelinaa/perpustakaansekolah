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
    public function index()
    {
        $result = Biblio::all();
        $publisher = Publisher::all();
        $author = Author::all();
        // dd($result);
        return view('frontend.index', compact('result', 'publisher', 'author'));
    }
}
