<?php

namespace App\Http\Controllers;

use App\Borrow;
use App\Item;
use App\Biblio;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = DB::table('borrows')
                ->join('users','users.id','=','borrows.users_id')
                ->select('borrows.*','users.name')
                ->get();
        return view('borrow.index', compact('result'));
    }

    // public function filter(Request $request){
    //     $start = $request->get('start');
    //     $end = $request->get('end');

    //     // $start = '2022-10-03';
    //     // $end = '2022-10-04';
    //     if($start != null && $end != null){
    //         $result = DB::table('borrows')
    //             ->join('users','users.id','=','borrows.users_id')
    //             ->select('borrows.*','users.name')
    //             ->whereBetween('borrows.borrow_date', [$start,$end])
    //             ->get();
    //     }else{
    //         $result = DB::table('borrows')
    //             ->join('users','users.id','=','borrows.users_id')
    //             ->select('borrows.*','users.name')
    //             ->get();
    //     }
        
    //     echo json_encode($result);
    // }

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

        $user = '0009224157';
        $register_num = '4/3/Per-C/Hd/2022';
        $biblios_id = Item::where('register_num',$register_num)->get();
        // dd($biblios_id[0]->biblios_id);

        // cek apakah id biblio yang mau dipinjam ada di daftar pesan
        $check_booking = DB::table('bookings')->select()->where('biblios_id', '=', $biblios_id[0]->biblios_id)->orderBy('booking_date', 'asc')->get();
        // dd($check_booking);
        if(count($check_booking) > 0){
            //jika ada
            // dd('Masuk ke if ada booking');
            //simpen id user yang pinjem ke array
            $arr_id = [];
            for($i = 0; $i < count($check_booking); $i++){
                $arr_id[] = $check_booking[$i]->nisn_niy;
            }

            // cek apakah user yang mau pinjam = yang sudah pesan di daftar pesanan yang terlebih dahulu pesan
            if($user == $arr_id[0]){
                dd('user sama dgn yang pesan pertama');
                
                // catat peminjaman, lalu hapus data bookings dengan biblios_id & nisn_niy yang ada
            }
            else{
                // kirim alert kalau ada di daftar pesanan
                // setelah di konfirm sama admin
                // 
                // 
                // 

                // cek apa ada di array peminjam, kalau iya nanti catat peminjaman, lalu hapus data bookings dengan biblios_id & nisn_niy yang ada
                if(in_array($user, $arr_id)){
                    dd('user ada didaftar pemesan tapi bukan yang paling dulu');
                }
                // kalau gaada di list peminjam
                else{
                    // catat peminjaman
                    dd('user tidak ada di daftar pesan sama sekali');
                }
            }
        }else{
            //Catat peminjaman
            dd('Masuk ke else, catat peminjaman langsung');
        }



        // try{
        //     $register_num = $request->get('register_num');
        //     $user = $request->get('user_num');

        //     $today = Carbon::now()->format('Y-m-d');
        //     $due = Carbon::now()->addDays(3)->format('Y-m-d');

        //     $borrow = new Borrow();
        //     $borrow->nisn_niy = $user;
        //     $borrow->borrow_date = $today;
        //     $borrow->due_date = $due;
        //     $borrow->status = "belum kembali";
        //     $borrow->total_fine = 0;

        //     // cek apakah ada di daftar pemesanan
        //     // cek kalo misal user ini udh pesen, dia urutan ke brp soalnya yang pinjem urutan 1

        //     $borrow->save();

        //     if($borrow){
        //         $borrow_trans = DB::table('borrow_transaction')->insert(['borrows_id' => $borrow->id, 'register_num' => $register_num]);
        //         if($borrow_trans){
        //             $request->session()->flash('status','Data peminjaman buku baru berhasil disimpan');
        //         }
        //         else{
        //             $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
        //         }
        //     }else{
        //         $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
        //     }

        // }catch (\PDOException $e) {
        //     $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
        // } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function show(Borrow $borrow)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function edit(Borrow $borrow)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Borrow $borrow)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Borrow  $borrow
     * @return \Illuminate\Http\Response
     */
    public function destroy(Borrow $borrow)
    {
        //
    }

    public function getDetail(Request $request){
        $id = $request->get('id');
        $data = DB::table('borrow_transaction')
                ->where('borrows_id','=',$id)
                ->get();
        // dd($data);
        return response()->json(array(
            'status'=>'OK',
            'msg'=>view('borrow.getDetailBorrowTransaction', compact('data'))->render()
        ), 200);
    }

    public function graphic(){
        $this_year = date('Y');

        $monthly_borrow = [];
        for($i = 1; $i <= 12; $i++){
            $count = DB::table('borrows') 
                            ->select(DB::raw('count(*) as count'))
                            ->where(DB::raw('year(borrow_date)'), '=', $this_year)
                            ->where(DB::raw('month(borrow_date)'),'=', $i)
                            ->get();
            $monthly_borrow[$i] = $count[0]->count;
        }

        // dd($monthly_borrow);
   
        return view('report.graphicBorrowReport', compact('monthly_borrow', 'this_year'));
    }

    public function listUser(){
        $data = DB::table('users')
                ->leftJoin('students','users.id','=','students.users_id')
                ->leftJoin('teachers','users.id','=','teachers.users_id')
                ->leftJoin('class','class.id','=','students.class_id')
                ->select('users.id','students.nisn','teachers.niy','users.name','class.name as class', 'users.role')
                ->orderBy('users.name', 'asc')
                ->get();

        // dd($data);
        return view('borrow.circulation', compact('data'));
    }

    public function detailCirculation($users_id){
        $user = DB::table('users')
                ->leftJoin('teachers','users.id','=','teachers.users_id')
                ->leftJoin('students','users.id','=','students.users_id')
                ->leftJoin('class','class.id','=','students.class_id')
                ->select('users.name','students.nisn','teachers.niy','class.name as class')
                ->where('users.id','=',$users_id)
                ->get();

        $data = DB::table('borrows')
                ->join('borrow_transaction','borrows.id','=','borrow_transaction.borrows_id')
                ->join('items','items.register_num', '=', 'borrow_transaction.register_num')
                ->join('biblios', 'biblios.id', '=', 'items.biblios_id')
                ->join('users','users.id', '=', 'borrows.users_id')
                ->select('borrows.id','borrows.borrow_date', 'borrows.due_date' ,'borrow_transaction.return_date', 'borrow_transaction.fine', 'borrow_transaction.status', 'items.register_num', 'biblios.title')
                ->where('users.id', '=', $users_id)
                ->get();

        // dd($data);
        return view('borrow.detailCirculation', compact('data','user'));
    }

    public function bookReturn(Request $request){
        try{
            $borrows_id = $request->get('id');
            $register_num = $request->get('reg_num');
            $fine = 0;

            $return_date = date('Y-m-d');

            $borrow_trans = DB::table('borrow_transaction')
                            ->join('borrows','borrows.id','=','borrow_transaction.borrows_id')
                            ->select('borrow_transaction.*', 'borrows.due_date')
                            ->where('borrows.id','=', $borrows_id)
                            ->where('borrow_transaction.register_num','=',$register_num)
                            ->get();
                            
            // Cek denda / tidak
            if($return_date > $borrow_trans[0]->due_date){
                $return_date = Carbon::parse($return_date);
                $due_date =Carbon::parse($borrow_trans[0]->due_date);
                $interval = $return_date->diffInDays($due_date);

                $fine = $interval * 500;
            }

            // update tabel -> kembalikan buku
            $update_borrow_trans = DB::table('borrow_transaction')
                            ->where('borrows_id','=', $borrows_id)
                            ->where('register_num','=',$register_num)
                            ->update(['status'=> 'sudah kembali','fine'=>$fine,'return_date'=>$return_date]);

            $update_item = DB::table('items')
                        ->where('register_num','=',$register_num)
                        ->update(['status'=> 'tersedia']);

            $get_total_fines = DB::table('borrow_transaction')
                        ->select(DB::raw('SUM(fine) as total_fine'))
                        ->where('borrows_id','=', $borrows_id)
                        ->get();

            // dd($get_total_fines[0]->total_fine);
            $update_borrow = DB::table('borrows')
                        ->where('id','=', $borrows_id)
                        ->update(['total_fine'=>$get_total_fines[0]->total_fine]);

            // dd($return_date);
            $request->session()->flash('status','Buku berhasil dikembalikan');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Buku gagal dikembalikan, silahkan coba lagi');
        }  
        
    }
}
