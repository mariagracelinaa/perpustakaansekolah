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

        $monthly_student = [];
        $monthly_teacher = [];
        for($i = 1; $i <= 12; $i++){
            $count_student = DB::table('visits') 
                            ->join('users', 'users.id', '=', 'visits.users_id')
                            ->select(DB::raw('count(*) as count'))
                            ->where(DB::raw('year(visits.visit_time)'), '=', $this_year)
                            ->where('users.role', '=', 'murid')
                            ->where(DB::raw('month(visits.visit_time)'),'=', $i)
                            ->get();
            $monthly_student[$i] = $count_student[0]->count;
        }
       
        for($i = 1; $i <= 12; $i++){
            $count_teacher = DB::table('visits') 
                            ->join('users', 'users.id', '=', 'visits.users_id')
                            ->select(DB::raw('count(*) as count'))
                            ->where(DB::raw('year(visits.visit_time)'), '=', $this_year)
                            ->where('users.role', '=', 'guru/staf')
                            ->where(DB::raw('month(visits.visit_time)'),'=', $i)
                            ->get();
            $monthly_teacher[$i] = $count_teacher[0]->count;
        }
                            
        // $weekly_student = DB::table('visits') 
        //                     ->join('users', 'users.nisn_niy', '=', 'visits.nisn_niy')
        //                     ->select(DB::raw('count(*)'))
        //                     ->where(DB::raw('year(visits.date)'), '=', $this_year)
        //                     ->where('users.role', '=', 'murid')
        //                     ->groupBy(DB::raw('week(visits.date)'))
        //                     ->get();

        // $weekly_teacher = DB::table('visits') 
        //                     ->join('users', 'users.nisn_niy', '=', 'visits.nisn_niy')
        //                     ->select(DB::raw('count(*)'))
        //                     ->where(DB::raw('year(visits.date)'), '=', $this_year)
        //                     ->where('users.role', '=', 'guru/staf')
        //                     ->groupBy(DB::raw('week(visits.date)'))
        //                     ->get();
        // dd($monthly_student);
        return view('report.visitReport', compact('monthly_student', 'monthly_teacher', 'this_year'));
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
