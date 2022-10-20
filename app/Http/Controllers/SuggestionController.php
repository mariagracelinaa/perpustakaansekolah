<?php

namespace App\Http\Controllers;

use App\Suggestion;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class SuggestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('check-admin');
        $data = Suggestion::where('is_deleted','=',0)->get();
        
        // dd($data);
        return view('suggestion.index', compact('data'));
    }

    public function getEditForm(Request $request){
        $id = $request->get('id');
        $data = Suggestion::find($id);
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('suggestion.getEditForm', compact('data'))->render()
        ), 200);
    }

    public function updateData(Request $request){
        $this->authorize('check-admin');
        $id = $request->get('id');
        $status = $request->get('status');

        // dd($status);
        try{
            $data = DB::table('suggestions')
                    ->where('id', $id)
                    ->update(['status' => $status]);
                    
            $request->session()->flash('status','Data usulan buku berhasil diubah');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Gagal mengubah data usulan buku, silahkan coba lagi');
        }  
    }

    public function deleteDataAdmin(Request $request){
        $this->authorize('check-admin');
        $id = $request->get('id');

        // dd($status);
        try{
            $data = DB::table('suggestions')
                    ->where('id', $id)
                    ->update(['is_deleted' => 1]);
                    
            $request->session()->flash('status','Data usulan buku berhasil dihapus');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Gagal menghapus data usulan buku, silahkan coba lagi');
        }  
    }

    public function printSuggestionReport(Request $request){
        $this->authorize('check-admin');
        $start = $request->get('start_date');
        $end = $request->get('end_date');
        
        $today = strftime('%d %B %Y');
        $data = DB::table('suggestions')
                ->join('users', 'users.id','=','suggestions.users_id')
                ->select('users.name', 'suggestions.title', 'suggestions.publisher', 'suggestions.author', 'suggestions.date', 'suggestions.status')
                ->where('is_deleted','=',0)
                ->where('status','=','proses review')
                ->whereBetween('suggestions.date', [$start,$end])
                ->get();

        $start = strftime('%d %B %Y', strtotime($start));
        $end = strftime('%d %B %Y', strtotime($end));
        // dd($data);
        return view('report.printSuggestionReport', compact('data', 'start', 'end', 'today'));
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
     * @param  \App\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function show(Suggestion $suggestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function edit(Suggestion $suggestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Suggestion $suggestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Suggestion  $suggestion
     * @return \Illuminate\Http\Response
     */
    public function destroy(Suggestion $suggestion)
    {
        //
    }
}
