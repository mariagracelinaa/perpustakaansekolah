<?php

namespace App\Http\Controllers;

use App\Visit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use DB;

use Auth;

class VisitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  Buku tamu
    public function index()
    {
        $this->authorize('check-admin');
        $role = "";
        $filter = "";

        $data = DB::table('users')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('users.*','class.name as class')
                ->where('users.role','!=', 'admin')
                ->orderBy('users.name', 'asc')
                ->get();

        $class = DB::table('class')->select()->get();

        // dd($data);
        return view('visit.index', compact('data','role','class','filter'));
    }

    public function index_filter(Request $request)
    {
        $this->authorize('check-admin');
        $role = $request->get('role');
        $filter = $request->get('filter');

        if($role == "guru/staf" || $role == 'murid'){
            $data = DB::table('users')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('users.*','class.name as class')
                ->where('users.role','=', $role)
                ->orderBy('users.name', 'asc')
                ->get();
        }else if($role == ""){
            $data = DB::table('users')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('users.*','class.name as class')
                ->where('users.role','!=', 'admin')
                ->orderBy('users.name', 'asc')
                ->get();
        }else{
            $data = DB::table('users')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('users.*','class.name as class')
                ->where('class.id', '=', $role)
                ->orderBy('users.name', 'asc')
                ->get();
        }

        $class = DB::table('class')->select()->get();

        // dd($data);
        return view('visit.index', compact('data','role','class','filter'));
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
        $filter = "";
        $start = "";
        $end = "";
        $role = "";

        $data = DB::table('visits')
                ->join('users','users.id','=','visits.users_id')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select(DB::raw('DATE_FORMAT(visits.visit_time, "%d-%m-%Y") as visit_time'),'visits.description','users.name','class.name as class')
                ->orderBy('visits.id', 'asc')
                ->get();
        
        $class = DB::table('class')->select()->get();

        // dd($data);
        return view('report.visitList', compact('data', 'class', 'start', 'end', 'role', 'filter'));
    }

    public function listVisit_filter(Request $request){
        $this->authorize('check-admin');
        // dd($request->get('filter'));
        $filter = $request->get('filter');
        $start = $request->get('date_start');
        $end = $request->get('date_end');
        $role = $request->get('role');
        // dd($filter, $role, $start, $end);
        if($filter == 'role'){
            if( $role == 'guru/staf'){
                $data = DB::table('visits')
                    ->join('users','users.id','=','visits.users_id')
                    ->leftJoin('class','class.id','=','users.class_id')
                    ->select(DB::raw('DATE_FORMAT(visits.visit_time, "%d-%m-%Y") as visit_time'),'visits.description','users.name','class.name as class')
                    ->where('users.role','=',$role)
                    ->orderBy('visits.id', 'asc')
                    ->get();
            }else if($role == "murid"){
                $data = DB::table('visits')
                    ->join('users','users.id','=','visits.users_id')
                    ->leftJoin('class','class.id','=','users.class_id')
                    ->select(DB::raw('DATE_FORMAT(visits.visit_time, "%d-%m-%Y") as visit_time'),'visits.description','users.name','class.name as class')
                    ->where('users.role','=',$role)
                    ->orderBy('visits.id', 'asc')
                    ->get();
            }
            else{
                $data = DB::table('visits')
                    ->join('users','users.id','=','visits.users_id')
                    ->leftJoin('class','class.id','=','users.class_id')
                    ->select(DB::raw('DATE_FORMAT(visits.visit_time, "%d-%m-%Y") as visit_time'),'visits.description','users.name','class.name as class')
                    ->where('class.id','=',$role)
                    ->orderBy('visits.id', 'asc')
                    ->get();
            }
        }else if($filter == 'date'){
            $data = DB::table('visits')
                    ->join('users','users.id','=','visits.users_id')
                    ->leftJoin('class','class.id','=','users.class_id')
                    ->select(DB::raw('DATE_FORMAT(visits.visit_time, "%d-%m-%Y") as visit_time'),'visits.description','users.name','class.name as class')
                    ->whereBetween('visits.visit_time', [$start, $end])
                    ->orderBy('visits.id', 'asc')
                    ->get();
        }
        // dd($data);
        $class = DB::table('class')->select()->get();
        return view('report.visitList', compact('data', 'class', 'start', 'end', 'role', 'filter'));
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

    // Form absensi tanpa login
    public function getFormAbsensi(){
        return view('checkin.index');
    }

    protected function validator_add_visit_no_login(array $data)
    {
        return Validator::make($data, [
            'email' => ['required'],
            'password' => ['required', 'string', 'min:8'],
            'desc' => ['required'],
        ],
        [
            'email.required' => 'Alamat email tidak boleh kosong',
            'password.required' => 'Kata sandi tidak boleh kosong',
            'desc.required' => 'Keperluan di perpustakaan tidak boleh kosong'
        ]);
    }

    // Catat absensi tanpa login dengan masukkan email dan password (Tanpa menyimpan session login)
    public function add_visit_no_login(Request $request){
        $this->validator_add_visit_no_login($request->all())->validate();
        // cek dulu email dan passwordnya
        $email = $request->get('email');
        $pwd_input = $request->get('password');
        $desc = $request->get('desc');
        $user = User::select('id','password')->where('email', '=', $email)->get();
        if(!$user->isEmpty()){
            if (Hash::check($pwd_input, $user[0]->password)) {
                try{
                    $users_id = $user[0]->id;
        
                    // dd($users_id);
        
                    // mendapatkan datetime skrg, sudah GMT+7 ganti di config->app.php->timezone, locale, faker_locale
                    $visit_time = date('Y-m-d');
                        
                    $data = new Visit();
                    $data->users_id = $users_id;
                    $data->visit_time = $visit_time;
                    $data->description = $desc;
                    $data->save();
        
                    return redirect()->back()->with('status','Data kunjungan baru berhasil disimpan');
        
                }catch (\PDOException $e) {
                        return redirect()->back()->with('error', 'Gagal menambah data baru, silahkan coba lagi');
                }
            }else{
                // dd("pwd salah");
                return redirect()->back()->with('error', 'Kata sandi salah, masukkan kata sandi dengan benar');
            }
        }else{
            return redirect()->back()->with('error', 'Alamat email yang dimasukkan tidak terdaftar');
        }
    }

    // Tampilkan page scan QR
    public function getPageScan(){
        return view('checkin.qr');
    }

    public function qr_read(Request $request){
        $email = $request->get('email');
        $user = User::select('id','password')->where('email', '=', $email)->get();
        if(!$user->isEmpty()){
            try{
                $users_id = $user[0]->id;
                $visit_time = date('Y-m-d');
                    
                $data = new Visit();
                $data->users_id = $users_id;
                $data->visit_time = $visit_time;
                $data->description = NULL;
                $data->save();
    
                $request->session()->flash('status','Data kunjungan baru berhasil disimpan');
    
            }catch (\PDOException $e) {
                $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
            }
        }else{
            $request->session()->flash('error', 'Data tidak ditemukan');
        }
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

    public function history_visit(){
        $this->authorize('check-user');
        $id = Auth::user()->id;
        $data = DB::table('visits')
                ->select()
                ->where('users_id','=', $id)
                ->orderBy('id','desc')
                ->get();

        // dd($data);
        return view('frontend.history_visit', compact('data'));
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
