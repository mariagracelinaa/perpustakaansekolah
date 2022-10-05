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
                ->orderBy('borrows.id','asc')
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
        $users_id = $request->get('users_id');
        $listBook = $request->get('listBook');

        $borrow_date = Carbon::now()->format('Y-m-d');
        $due_date = Carbon::now()->addDays(3)->format('Y-m-d');
        
        try{
            $borrow = new Borrow();
            $borrow->users_id = $users_id;
            $borrow->borrow_date = $borrow_date;
            $borrow->due_date = $due_date;
            $borrow->total_fine = 0;
            $borrow->save();

            if($borrow){
                for($i = 0; $i < count($listBook); $i++){
                    $biblios_id = Item::where('register_num',$listBook[$i])->get();
                    // dd($biblios_id[0]->biblios_id);

                    // cek apakah id biblio yang mau dipinjam ada di daftar pesan
                    $check_booking = DB::table('bookings')->select()->where('biblios_id', '=', $biblios_id[0]->biblios_id)->orderBy('booking_date', 'asc')->get();
                    // dd($check_booking);
                    if(count($check_booking) > 0){
                        //jika ada
                        // dd('Masuk ke if ada booking');
                        //simpen id user yang pinjem ke array
                        $arr_id = [];
                        for($j = 0; $j < count($check_booking); $j++){
                            $arr_id[] = $check_booking[$j]->users_id;
                        }
                        
                        // dd($arr_id, $users_id);
                        // cek apakah user yang mau pinjam = yang sudah pesan di daftar pesanan maka catat peminjaman dan hapus dari list pesanan
                        if(in_array($users_id, $arr_id)){

                            $auth_biblio = DB::table('borrow_transaction')
                                            ->insert(['borrows_id' => $borrow->id, 'register_num' => $listBook[$i]]);

                            // update status ketersediaan item buku
                            DB::table('items')
                            ->where('register_num','=',$listBook[$i])
                            ->update(['status'=> 'dipinjam']);

                            // delete dari bookings
                            DB::table('bookings')->where('users_id', '=', $users_id)->where('biblios_id','=',$biblios_id[0]->biblios_id)->delete();
                          
                        }
                        else{
                                // Simpan tabel borrow_transaction
                            $auth_biblio = DB::table('borrow_transaction')
                                            ->insert(['borrows_id' => $borrow->id, 'register_num' => $listBook[$i]]);

                            DB::table('items')
                            ->where('register_num','=',$listBook[$i])
                            ->update(['status'=> 'dipinjam']);
                           
                        }
                    }else{
                            // Simpan tabel borrow_transaction
                        $auth_biblio = DB::table('borrow_transaction')
                                        ->insert(['borrows_id' => $borrow->id, 'register_num' => $listBook[$i]]);

                        DB::table('items')
                        ->where('register_num','=',$listBook[$i])
                        ->update(['status'=> 'dipinjam']);
                        
                    }   
                }
            }
            return session()->flash('status','Catatan peminjaman berhasil ditambahkan');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Gagal menambah data baru, silahkan coba lagi');
        } 
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
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('users.id','users.nisn','users.niy','users.name','class.name as class', 'users.role')
                ->orderBy('users.name', 'asc')
                ->get();

        // dd($data);
        return view('borrow.circulation', compact('data'));
    }

    // untuk dihalaman tambah sirkulasi buku/peminjaman
    public function detailAddCirculation($users_id){
        $user = DB::table('users')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('users.id as users_id','users.name','users.nisn','users.niy','class.name as class')
                ->where('users.id','=',$users_id)
                ->get();

        // dd($user);
        return view('borrow.addCirculation', compact('user'));
    }

    public function detailCirculation($users_id){
        $user = DB::table('users')
                ->leftJoin('class','class.id','=','users.class_id')
                ->select('users.id as users_id','users.name','users.nisn','users.niy','class.name as class')
                ->where('users.id','=',$users_id)
                ->get();

        $data = DB::table('borrows')
                ->join('borrow_transaction','borrows.id','=','borrow_transaction.borrows_id')
                ->join('items','items.register_num', '=', 'borrow_transaction.register_num')
                ->join('biblios', 'biblios.id', '=', 'items.biblios_id')
                ->join('users','users.id', '=', 'borrows.users_id')
                ->select('borrows.id','borrows.borrow_date', 'borrows.due_date' ,'borrow_transaction.return_date', 'borrow_transaction.fine', 'borrow_transaction.status', 'items.register_num', 'biblios.title')
                ->where('users.id', '=', $users_id)
                ->orderBy('borrows.id', 'desc')
                ->get();

        // dd($data);
        return view('borrow.detailCirculation', compact('data','user'));
    }

    public function bookReturn(Request $request){
        try{
            $borrows_id = $request->get('id');
            $register_num = $request->get('reg_num');
            $fine = 0;

            // Tanggal hari ini (return_date)
            $return_date =  Carbon::now()->format('Y-m-d');

            // Ambil data peminjaman dengan id peminjaman dan nomor register buku yang akan dikembalikan
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

            // update tabel -> status item buku di tabel items
            $update_item = DB::table('items')
                        ->where('register_num','=',$register_num)
                        ->update(['status'=> 'tersedia']);

            
            $get_total_fines = DB::table('borrow_transaction')
                        ->select(DB::raw('SUM(fine) as total_fine'))
                        ->where('borrows_id','=', $borrows_id)
                        ->get();

            // dd($get_total_fines[0]->total_fine);
            // update tabel -> total denda di tabel borrows
            $update_borrow = DB::table('borrows')
                        ->where('id','=', $borrows_id)
                        ->update(['total_fine'=>$get_total_fines[0]->total_fine]);

            // dd($return_date);
            $request->session()->flash('status','Buku berhasil dikembalikan');
        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Buku gagal dikembalikan, silahkan coba lagi');
        }  
    }

    public function bookExtension(Request $request){
        try{
            $borrows_id = $request->get('id');
            $register_num = $request->get('reg_num');
            // ambil data booking dari nomor registrasi buku yang akan diperpanjang
            $check_booking = DB::table('items')
                            ->join('biblios','biblios.id','=','items.biblios_id')
                            ->join('bookings','biblios.id','=','bookings.biblios_id')
                            ->select('bookings.*')
                            ->where('items.register_num','=', $register_num)
                            ->get();

            // dd($check_booking);
            // Jika ada di daftar booking
            if(!$check_booking->isEmpty()){
                // cek stok item buku kosong atau tidak
                // Jika kosong maka tidak bisa perpanjang
                $check_count_item = DB::table('items')
                                    ->select(DB::raw('COUNT(*) as count'))
                                    ->where('biblios_id','=',$check_booking[0]->biblios_id)
                                    ->where('status','=','tersedia')
                                    ->where('is_deleted','=',0)
                                    ->get();
                
                if($check_count_item[0]->count == 0){
                    $request->session()->flash('error', 'Buku gagal diperpanjang, stok buku di perpustakaan sedang tidak ada dan buku sedang ada di daftar pesanan pengguna lain');
                }else{
                    // panggil function untuk masukkan data perpanjangan
                    $this->extendTask($borrows_id, $register_num);
                }
            }else{
                // panggil function untuk masukkan data perpanjangan
                $this->extendTask($borrows_id, $register_num);
            }

        }catch (\PDOException $e) {
            $request->session()->flash('error', 'Buku gagal diperpanjang, silahkan coba lagi');
        }   
    }

    public function extendTask($borrows_id, $register_num){
        // dd("Masuk Function extendTask");
        try{
            $fine = 0;

            // dd($borrows_id, $register_num);

            // Tanggal hari ini (return_date)
            $return_date =  Carbon::now()->format('Y-m-d');

            // Ambil data peminjaman dengan id peminjaman dan nomor register buku yang akan dikembalikan
            $borrow_trans = DB::table('borrow_transaction')
                            ->join('borrows','borrows.id','=','borrow_transaction.borrows_id')
                            ->select('borrow_transaction.*', 'borrows.due_date', 'borrows.users_id as users_id')
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
            
            $get_total_fines = DB::table('borrow_transaction')
                        ->select(DB::raw('SUM(fine) as total_fine'))
                        ->where('borrows_id','=', $borrows_id)
                        ->get();

            // update tabel -> total denda di tabel borrows
            $update_borrow = DB::table('borrows')
                        ->where('id','=', $borrows_id)
                        ->update(['total_fine'=>$get_total_fines[0]->total_fine]);

            // Catat perpanjangan sebagai transaksi peminjaman baru
            // Simpan tabel borrows
            $borrow_date = $return_date;
            $due_date = Carbon::now()->addDays(3)->format('Y-m-d');

            // dd($borrow_date,$due_date);
            $borrow = new Borrow();
            $borrow->users_id = $borrow_trans[0]->users_id;
            $borrow->borrow_date = $borrow_date;
            $borrow->due_date = $due_date;
            $borrow->total_fine = 0;
            $borrow->save();

            if($borrow){
                // Simpan tabel borrow_transaction
                $auth_biblio = DB::table('borrow_transaction')
                                ->insert(['borrows_id' => $borrow->id, 'register_num' => $register_num]);
            }
            // dd($return_date);
            return session()->flash('status','Buku berhasil diperpanjang');
        }catch (\PDOException $e) {
            return session()->flash('error', 'Buku gagal diperpanjang, silahkan coba lagi');
        }
    }
}
