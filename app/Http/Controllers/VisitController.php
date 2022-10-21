<?php

namespace App\Http\Controllers;

use App\Visit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
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
        $this->authorize('check-admin');
        $data = DB::table('users')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('users.*','class.name as class')
                ->orderBy('users.name', 'asc')
                ->get();

        // dd($data);
        return view('visit.index', compact('data'));
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

    public function graphic(Request $request){
        $this->authorize('check-admin');
        $this_year =  date('Y');

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
        return view('report.graphicVisitReport', compact('monthly_student', 'monthly_teacher', 'this_year'));
    }

    public function graphicYear(Request $request){
        $this->authorize('check-admin');
        $this_year = $request->get('year');

        $monthly_student = "";
        $monthly_teacher = "";
        for($i = 1; $i <= 12; $i++){
            $count_student = DB::table('visits') 
                            ->join('users', 'users.id', '=', 'visits.users_id')
                            ->select(DB::raw('count(*) as count'))
                            ->where(DB::raw('year(visits.visit_time)'), '=', $this_year)
                            ->where('users.role', '=', 'murid')
                            ->where(DB::raw('month(visits.visit_time)'),'=', $i)
                            ->get();
            $monthly_student .= $count_student[0]->count.",";
        }
       
        for($i = 1; $i <= 12; $i++){
            $count_teacher = DB::table('visits') 
                            ->join('users', 'users.id', '=', 'visits.users_id')
                            ->select(DB::raw('count(*) as count'))
                            ->where(DB::raw('year(visits.visit_time)'), '=', $this_year)
                            ->where('users.role', '=', 'guru/staf')
                            ->where(DB::raw('month(visits.visit_time)'),'=', $i)
                            ->get();
            $monthly_teacher .= $count_teacher[0]->count.",";
        }

        // dd($monthly_student, $monthly_teacher);
        return response()->json(array('student' => $monthly_student, 'teacher' => $monthly_teacher, 'year' => $this_year));
        // return view('report.graphicVisitReportFilter', compact('this_year'));
    }

    public function getAddForm(Request $request){
        $id = $request->get('id');
        $data = User::find($id);
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('visit.getAddForm', compact('data'))->render()
        ), 200);
    }

    public function listVisit(){
        $this->authorize('check-admin');
        $data = DB::table('visits')
                ->join('users','users.id','=','visits.users_id')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('visits.*','users.*','class.name as class')
                ->orderBy('visits.id', 'asc')
                ->get();

        // dd($data);
        return view('report.visitList', compact('data'));
    }

    public function addVisit(Request $request){
        $this->authorize('check-admin');
        $validator = \Validator::make($request->all(), [
            'desc' => 'required',
        ],
        [
            'desc.required' => 'Keperluan di perpustakaan harus diisikan',
        ]);
        
        if (!$validator->passes())
        {
            return response()->json(['status'=>0, 'errors'=>$validator->errors()->toArray()]);
        }else{
            try{
            $users_id = $request->get('id');
            $desc = $request->get('desc');

            // dd($users_id);

            // mendapatkan datetime skrg, sudah GMT+7 ganti di config->app.php->timezone, locale, faker_locale
            $visit_time = date('Y-m-d');
                
            $data = new Visit();
            $data->users_id = $users_id;
            $data->visit_time = $visit_time;
            $data->description = $desc;
            $data->save();

            $request->session()->flash('status','Data kunjungan baru berhasil disimpan');

            }catch (\PDOException $e) {
                $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
            }
        }
    }

    public function printVisitReport(Request $request){
        $this->authorize('check-admin');
        $start = $request->get('start_date');
        $end = $request->get('end_date');
        // dd($start, $end);
        
        $today = Carbon::now()->format('d F Y');
        $data = DB::table('visits')
                ->join('users','users.id','=','visits.users_id')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('visits.*','users.id','users.name','class.name as class', 'users.role')
                ->whereBetween('visits.visit_time', [$start,$end])
                ->orderBy('visits.visit_time','asc')
                ->get();
        // dd($data);
        return view('report.printVisitList', compact('data', 'start', 'end', 'today'));
    }

    // ----------------------------------------- FRONT END ------------------------------------------------
    protected function validatorVisit(array $data)
    {
        return Validator::make($data, [
            'desc' => 'required',
        ],
        [
            'desc.required' => 'Keperluan di perpustakaan harus diisikan',
        ]);
    }
    public function visitUserAdd(Request $request){
        $this->authorize('check-user');
        $this->validatorVisit($request->all())->validate();
        
        // dd($request->get('id'), $request->get('desc'));
        try{
            $users_id = $request->get('id');
            $desc = $request->get('desc');

            // dd($users_id);

            // mendapatkan datetime skrg, sudah GMT+7 ganti di config->app.php->timezone, locale, faker_locale
            $visit_time = date('Y-m-d');
                
            $data = new Visit();
            $data->users_id = $users_id;
            $data->visit_time = $visit_time;
            $data->description = $desc;
            $data->save();

            return redirect('/')->with('status','Data kunjungan baru berhasil disimpan');

        }catch (\PDOException $e) {
            return redirect('/')->with('error', 'Gagal menambah data baru, silahkan coba lagi');
        }
    }

    public function getVisitForm(){
        return view('frontend.checkin');
    }
}
