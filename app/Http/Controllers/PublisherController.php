<?php

namespace App\Http\Controllers;

use App\Publisher;
use Illuminate\Http\Request;
use DB;

class PublisherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-admin');
        $result = Publisher::all();
        return view('publisher.index', compact('result'));
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
            'city' => 'required'
        ],
        [
            'name.required' => 'Nama penerbit tidak boleh kosong',
            'city.required' => 'Kota penerbit tidak boleh kosong',
        ]);
        
        if (!$validator->passes())
        {
            return response()->json(['status'=>0, 'errors'=>$validator->errors()->toArray()]);
        }else{
            try{
                $data = new Publisher();
                $data->name = $request->get('name');
                $data->city = $request->get('city');
                $data->save();
    
                $request->session()->flash('status','Data penerbit baru berhasil disimpan');
            }catch (\PDOException $e) {
                $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
            }
        }   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(Publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit(Publisher $publisher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publisher $publisher)
    {
        // try{
        //     $publisher->name = $request->get('name');
        //     $publisher->city = $request->get('city');
            // $publiser->save();
            // dd($publisher);
            // return redirect()->route('daftar-penerbit.index')->with('status', 'Data penerbit berhasil diubah');
        // }catch (\PDOException $e) {
        //     return redirect()->route('daftar-penerbit.index')->with('error', 'Data penerbit gagal diubah, silahkan coba lagi');
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publisher $publisher)
    {
        //
    }

    public function getEditForm(Request $request){
        $id = $request->get('id');
        $data = Publisher::find($id);
        // dd($data);
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('publisher.getEditForm', compact('data'))->render()
        ), 200);
    }

    public function updateData(Request $request){
        $this->authorize('check-admin');
        $id = $request->get('id');
        $name = $request->get('name');
        $city = $request->get('city');
        try{
            $data = DB::table('publishers')
                    ->where('id', $id)
                    ->update(['name' => $name, 'city' => $city]);

            $request->session()->flash('status','Data penerbit berhasil diubah');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Gagal mengubah data penerbit, silahkan coba lagi');
        }  
    }
}
