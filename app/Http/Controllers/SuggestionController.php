<?php

namespace App\Http\Controllers;

use App\Suggestion;
use App\User;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
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
        $data = DB::table('suggestions')
            ->join('users','users.id','=','suggestions.users_id')
            ->select('suggestions.id','users.name', 'suggestions.title','suggestions.author', 'suggestions.publisher', 'suggestions.description', 'suggestions.status', DB::raw('DATE_FORMAT(suggestions.date, "%d-%m-%Y") as date'))
            ->where('is_deleted','=',0)
            ->get();
            
        $filter = "";
        $start = "";
        $end = "";
        $status = "";
        // dd($data);
        return view('suggestion.index', compact('data', 'filter', 'start', 'end', 'status'));
    }

    public function filter_data(Request $request){
        $this->authorize('check-admin');
        // dd($request->get('start_date'), $request->get('end_date'), $request->get('status'), $request->get('filter'));
        $filter = $request->get('filter');
        $start = $request->get('date_start');
        $end = $request->get('date_end');
        $status = $request->get('status');
        // dd($filter,$status);
        if($filter == 'status'){
            // dd('masuk ke query seect where status');
            // $data = Suggestion::where('status','=', $request->get('status'))->get();

            $data = DB::table('suggestions')
                    ->join('users','users.id','=','suggestions.users_id')
                    ->select('suggestions.id','users.name', 'suggestions.title','suggestions.author', 'suggestions.publisher', 'suggestions.description', 'suggestions.status', DB::raw('DATE_FORMAT(suggestions.date, "%d-%m-%Y") as date'))
                    ->where('status','=', $status)
                    ->get();
        
            // dd($data);
        }else if($filter == 'date'){
            // dd('masuk ke query seect where between tgl');
            // $data = Suggestion::whereBetween('date', [$request->get('start_date'), $request->get('end_date')])->get();
            // dd($data);
            $data = DB::table('suggestions')
                    ->join('users','users.id','=','suggestions.users_id')
                    ->select('suggestions.id','users.name', 'suggestions.title','suggestions.author', 'suggestions.publisher', 'suggestions.description', 'suggestions.status', DB::raw('DATE_FORMAT(suggestions.date, "%d-%m-%Y") as date'))
                    ->whereBetween('date', [$start, $end])
                    ->get();
        }
        return view('suggestion.index', compact('data', 'filter', 'start', 'end', 'status'));
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

    // ----------------------------------------- FRONT END ------------------------------------------------
    protected function validatorSuggestion(array $data)
    {
        return Validator::make($data, [
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
        ],
        [
            'title.required' => 'Judul buku usulan tidak boleh kosong',
            'author.required' => 'Nama penulis tidak boleh kosong',
            'publisher.required' => 'Nama penerbit tidak boleh kosong',
        ]);
    }

    public function getSugesstionForm(){
        return view('frontend.formSuggestion');
    }

    public function addSuggestionUser(Request $request){
        $this->authorize('check-user');
        $this->validatorSuggestion($request->all())->validate();
        try{
            $desc = NULL;
            if($request->get('desc') != ""){
                $desc = $request->get('desc');
            }

            $data = new Suggestion();
            $data->users_id = $request->get('id');
            $data->title = $request->get('title');
            $data->author = $request->get('author');
            $data->publisher = $request->get('publisher');
            $data->date = date('Y-m-d');
            $data->status = "proses review";
            $data->description = $desc;
            $data->is_deleted = 0;
            $data->save();

            return redirect('/daftar-usulan')->with('status','Data usulan baru berhasil disimpan');
        }catch (\PDOException $e) {
            return redirect('/daftar-usulan')->with('error', 'Gagal menambah data usulan buku, silahkan coba lagi');
        }  
    }

    public function front_index(){
        $this->authorize('check-user');
        $data = Suggestion::where('is_deleted','=',0)->orderBy('date','desc')->get();
        // dd($data[0]->users->name);
        return view('frontend.suggestion', compact('data'));
    }

    public function mySuggestion($id){
        $this->authorize('check-user');
        $data = Suggestion::where('users_id','=', $id)->orderBy('date','desc')->get();
        // dd($data);
        return view('frontend.mySuggestion', compact('data'));
    }

    public function getEditFormUser($id){
        $this->authorize('check-user');
        $data = Suggestion::find($id);
        return view('frontend.editSuggestion', compact('data'));
    }

    public function editSuggestion(Request $request){
        $this->authorize('check-user');
        $this->validatorSuggestion($request->all())->validate();
        try{
            $desc = NULL;
            if($request->get('desc') != ""){
                $desc = $request->get('desc');
            }

            $data = DB::table('suggestions')
                    ->where('id', $request->get('id'))
                    ->update(['title' => $request->get('title'),'author' => $request->get('author'), 'publisher' => $request->get('publisher'), "description" => $request->get('desc')]);

            return redirect('/usulan-saya/'.$request->get('users_id'))->with('status','Data usulan baru berhasil disimpan');
        }catch (\PDOException $e) {
            return redirect('/usulan-saya/'.$request->get('users_id'))->with('error', 'Gagal menambah data usulan buku, silahkan coba lagi');
        }
    }

    public function deleteSuggestionUser($id){
        try{
            $deleted = Suggestion::where('id', $id)->delete();

            return redirect()->back()->with('status','Data berhasil dihapus');
        }catch (\PDOException $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data usulan buku, silahkan coba lagi');
        }
       
    }
}
