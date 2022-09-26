<?php

namespace App\Http\Controllers;

use App\Visit;
use Illuminate\Http\Request;
use DB;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this_year = date('Y');
        $this_month = date('m');
        

        $data = DB::table('deletions')
        ->join('items', 'items.register_num','=','deletions.register_num')
        ->join('biblios', 'items.biblios_id','=','biblios.id')
        ->select('deletions.*', 'biblios.title', 'items.source', 'items.price')
        ->get();

        $monthly_student = DB::table('visits') 
                            ->join('users', 'users.nisn_niy', '=', 'visits.nisn_niy')
                            ->select(DB::raw('count(*)'))
                            ->where(DB::raw('year(visits.date)'), '=', $this_year)
                            ->where('users.role', '=', 'murid')
                            ->groupBy(DB::raw('month(visits.date)'))
                            ->get();

        $monthly_teacher = DB::table('visits') 
                            ->join('users', 'users.nisn_niy', '=', 'visits.nisn_niy')
                            ->select(DB::raw('count(*)'))
                            ->where(DB::raw('year(visits.date)'), '=', $this_year)
                            ->where('users.role', '=', 'guru/staf')
                            ->groupBy(DB::raw('month(visits.date)'))
                            ->get();

                            
        $weekly_student = DB::table('visits') 
                            ->join('users', 'users.nisn_niy', '=', 'visits.nisn_niy')
                            ->select(DB::raw('count(*)'))
                            ->where(DB::raw('year(visits.date)'), '=', $this_year)
                            ->where('users.role', '=', 'murid')
                            ->groupBy(DB::raw('week(visits.date)'))
                            ->get();

        $weekly_teacher = DB::table('visits') 
                            ->join('users', 'users.nisn_niy', '=', 'visits.nisn_niy')
                            ->select(DB::raw('count(*)'))
                            ->where(DB::raw('year(visits.date)'), '=', $this_year)
                            ->where('users.role', '=', 'guru/staf')
                            ->groupBy(DB::raw('week(visits.date)'))
                            ->get();
        // dd($this_month);
        return view('report.visitReport');
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
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function show(Visit $visit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function edit(Visit $visit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visit $visit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visit  $visit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visit $visit)
    {
        //
    }
}
