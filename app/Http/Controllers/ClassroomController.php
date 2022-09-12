<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\User;
use Illuminate\Http\Request;
use DB;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = Classroom::all();

        $count = DB::table('classrooms')
                ->Select(DB::raw('count(users.classrooms_id) as total_murid'))
                ->leftJoin('users','users.classrooms_id','=','classrooms.id')
                ->groupBy('classrooms.id')
                ->orderBy('classrooms.id', 'asc')
                ->get();

        $class = Classroom::select()->count();
        // dd($count);
        return view('classroom.index', compact('result', 'count', 'class'));
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
            $data = new Classroom();
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
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function show(Classroom $classroom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function edit(Classroom $classroom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classroom $classroom)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Classroom  $classroom
     * @return \Illuminate\Http\Response
     */
    public function destroy(Classroom $classroom)
    {
        //
    }

    public function getEditForm(Request $request){
        $id = $request->get('id');
        $data = Classroom::find($id);
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('classroom.getEditForm', compact('data'))->render()
        ), 200);
    }

    public function updateData(Request $request){
        $id = $request->get('id');
        $name = $request->get('name');
        try{
            $data = DB::table('classrooms')
                    ->where('id', $id)
                    ->update(['name' => $name]);
                    
            $request->session()->flash('status','Data ruang kelas berhasil diubah');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Gagal mengubah data ruang kelas, silahkan coba lagi');
        }  
    }
}
