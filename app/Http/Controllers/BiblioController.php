<?php

namespace App\Http\Controllers;

use App\Biblio;
use Illuminate\Http\Request;

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
        // $result = Biblio::find(2);
        // dd($result);
        return view('biblio.index', compact('result'));
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
        //
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
