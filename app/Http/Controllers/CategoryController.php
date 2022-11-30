<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('categories')->select()->get();
        return view('category.index', compact('data'));
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
                $ddc = $request->get('ddc');
                $name = $request->get('name');

                DB::table('categories')->insert(['ddc' => $ddc, 'name' => $name]);

                $request->session()->flash('status','Data kategori baru berhasil disimpan');
            }catch (\PDOException $e) {
                $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getEditForm(Request $request){
        $id = $request->get('id');
        $data = Category::find($id);
        // dd($data);
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('category.getEditForm', compact('data'))->render()
        ), 200);
    }

    public function updateData(Request $request){
        $this->authorize('check-admin');
        // dd($request->get('eName'));
        $validator = \Validator::make($request->all(), [
            'eName' => 'required',
            'eddc' => 'required',
        ],
        [
            'eName.required' => 'Nama penulis tidak boleh kosong',
            'eddc.required' => 'Kategori DDC harus dipilih',
        ]);
        
        if (!$validator->passes())
        {
            return response()->json(['status'=>0, 'errors'=>$validator->errors()->toArray()]);
        }else{
            $id = $request->get('id');
            $name = $request->get('eName');
            $ddc = $request->get('eddc');
            try{
                $data = DB::table('categories')
                        ->where('id', $id)
                        ->update(['name' => $name, 'ddc' => $ddc]);
                        
                $request->session()->flash('status','Data kategori berhasil diubah');
            }catch (\PDOException $e) {
                $request->session()->flash('error', 'Gagal mengubah data kategori, silahkan coba lagi');
            }  
        }
    }
}
