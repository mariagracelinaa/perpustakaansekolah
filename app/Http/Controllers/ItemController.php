<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::where('register_num', '0001/per-C/Hd/2020/1')->first();
        // $items = Item::all();
        dd($items->biblios->title);
        // echo $items;
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
        try{
            $biblios_id = $request->get('id');
            
            $price = $request->get('price');

            //Kode sumber
            $source_code = "";
            if($request->get('source') == "pembelian"){
                $source_code = "Pb";
            }else{
                $source_code = "Hd";
            }

            $source = $request->get('source');

            // Mendapatkan jumlah item pada id biblio tertentu
            $count = Item::where('biblios_id', $biblios_id)->count();
            $count++;

            // Cari tgl hr ini date('Y-m-d H:i:s');
            $year = $request->get('year');

            $register_num = $biblios_id."/".$count."/"."Per-C/".$source_code."/".$year;
    
            // dd($data);
            DB::table('items')->insert(['register_num' => $register_num, 'biblios_id' => $biblios_id, 'source' => $source, 'purchase_year' => $year , 'price' => $price, 'status' => 'tersedia', 'is_deleted' => 0]);
            
            return redirect()->route('daftar-buku-detail', ['id' => $biblios_id])->with('status','Data item buku baru berhasil disimpan');
            // return redirect()->url('daftar-buku-detail/{{$biblios_id}}')->with('status','Data item buku baru berhasil disimpan');
            // return redirect()->route('daftar-buku-detail/{{$biblios_id}}')->with('status','Data item buku baru berhasil disimpan');
        }catch (\PDOException $e) {
            // return redirect()->route('daftar-buku-detail/{{$biblios_id}}')->with('error', 'Gagal menambah data baru, silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        //
    }

    public function getEditForm(Request $request){
        $id = $request->get('id');
        // $id = "12/1/Per-C/Hd/2022";
        $data = Item::where('register_num', $id)->get();
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('biblio.editItem', compact('data'))->render()
        ), 200);
    }

    public function updateData(Request $request){
        try{
            $id = $request->get('id');
            $source = $request->get('source');
            $price = $request->get('price');
            $year = $request->get('year');

            $data = DB::table('items')
                    ->where('register_num', $id)
                    ->update(['source' => $source, 'price' => $price, 'purchase_year' => $year]);

            $request->session()->flash('status','Data item buku berhasil diubah');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Gagal mengubah data item buku, silahkan coba lagi');
        }  
    }
}
