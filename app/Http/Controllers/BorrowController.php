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
        $result = Borrow::all();

        // $borrow_trans = $result[0]->items->title;

        // dd($result);
        // return view('biblio.borrow');
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
}
