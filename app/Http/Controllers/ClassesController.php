<?php

namespace App\Http\Controllers;

use App\Classes;
use Illuminate\Http\Request;
use DB;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Classes::all();

        $count = DB::table('class')
                ->Select(DB::raw('count(users.class_id) as total_murid'))
                ->leftJoin('users','users.class_id','=','class.id')
                ->groupBy('class.id')
                ->orderBy('class.id', 'asc')
                ->get();

        $class = Classes::select()->count();
        // dd($count);
        return view('class.index', compact('result', 'count', 'class'));
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
            $data = new Classes();
            $data->name = $request->get('name');
            $data->save();

            return redirect()->route('daftar-kelas.index')->with('status','Data ruang kelas baru berhasil disimpan');
        }catch (\PDOException $e) {
            return redirect()->route('daftar-kelas.index')->with('error', 'Gagal menambah data baru, silahkan coba lagi');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classes $classes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classes $classes)
    {
        //
    }

    public function getEditForm(Request $request){
        $id = $request->get('id');
        $data = Classes::find($id);
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('class.getEditForm', compact('data'))->render()
        ), 200);
    }

    public function updateData(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        try{
            $data = DB::table('class')
                    ->where('id', $id)
                    ->update(['name' => $name]);
                    
            $request->session()->flash('status','Data ruang kelas berhasil diubah');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Gagal mengubah data ruang kelas, silahkan coba lagi');
        }  
    }
}
