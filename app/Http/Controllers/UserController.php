<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Classes;
use DB;

class UserController extends Controller
{
    public function student()
    {
        $data = DB::table('users')
                ->join('class', 'users.class_id','=','class.id')
                ->select('users.id','users.nisn','users.name','users.email', 'class.name as class')
                ->where('role','=','murid')
                ->get();

        // dd($data);
        return view('user.student', compact('data'));
    }

    public function teacher()
    {
        $data = DB::table('users')
                ->select('users.id','users.niy','users.name','users.email')
                ->where('role','=','guru/staf')
                ->get();

        return view('user.teacher', compact('data'));
    }

    public function getEditForm($users_id){
        $data =  User::find($users_id);

        $class = Classes::all();
        // dd($data);
        return view('user.editUserAdmin', compact('data','class'));
    }

    public function editDataUserAdmin(Request $request){
        $id = $request->get('id');
        $class_id = $request->get('class_id');
        $nisn_niy = $request->get('nisn/niy');
        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password_new');
        $role = $request->get('role');

        // dd($role);

        if( $role == 'Murid'){
            $role = 'murid';
        }elseif($role == 'Guru/Staf'){
            $role = 'guru/staf';
        }

        // dd($id,$class_id, $nisn_niy, $name, $email, $password, $role);
        try{
            $all = DB::table('users')
                    ->where('id', $id)
                    ->update(['name' => $name,'email' => $email, 'role' => $role]);

            if($role == 'murid'){
                // dd("masuk murid");
                $student = DB::table('users')
                        ->where('id', $id)
                        ->update(['nisn' => $nisn_niy,'niy' => NULL,'class_id' => $class_id]);
            }elseif($role == 'guru/staf'){
                // dd("masuk guru");
                $student = DB::table('users')
                        ->where('id', $id)
                        ->update(['nisn' => NULL,'niy' => $nisn_niy,'class_id' => NULL]);
            }else{
                // dd("masuk admin");
                $admin = DB::table('users')
                        ->where('id', $id)
                        ->update(['nisn' => NULL,'niy' => NULL,'class_id' => NULL]);
            }

            if($password != NULL){
                $password_update = DB::table('users')
                        ->where('id', $id)
                        ->update(['password' => Hash::make($password)]);
            }

            if($role == 'murid'){
                return redirect()->back()->with('status','Data murid berhasil diubah');
            }elseif($role == 'guru/staf'){
                return redirect()->back()->with('status','Data guru/staf berhasil diubah');
            }else{
                return redirect()->back()->with('status','Data murid berhasil diubah');
            }
            
        }catch (\PDOException $e) {
            if($role == 'murid'){
                return redirect()->back()->with('error', 'Gagal mengubah data murid, silahkan coba lagi');
            }elseif($role == 'guru/staf'){
                return redirect()->back()->with('error', 'Gagal mengubah data guru/staf, silahkan coba lagi');
            }else{
                return redirect()->back()->with('error', 'Gagal mengubah data diri, silahkan coba lagi');
            }
        }  
    }

    public function editPasswordUser(Request $request){

    }
}
