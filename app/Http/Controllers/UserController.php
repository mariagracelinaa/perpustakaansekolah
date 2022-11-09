<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Classes;
use DB;

class UserController extends Controller
{
    public function student()
    {
        $this->authorize('check-admin');
        $data = DB::table('users')
                ->join('class', 'users.class_id','=','class.id')
                ->select('users.id','users.nisn','users.name','users.email', 'class.name as class')
                ->where('role','=','murid')
                ->where('is_active','=',1)
                ->get();

        // dd($data);
        return view('user.student', compact('data'));
    }

    public function teacher()
    {
        $this->authorize('check-admin');
        $data = DB::table('users')
                ->select('users.id','users.niy','users.name','users.email')
                ->where('role','=','guru/staf')
                ->where('is_active','=',1)
                ->get();

        return view('user.teacher', compact('data'));
    }

    public function is_active($users_id){
        $this->authorize('check-admin');
        $role = DB::table('users')
                ->select('role')
                ->where('id', $users_id)
                ->get();

        $data = DB::table('users')
                ->where('id', $users_id)
                ->update(['is_active' => 0]);

        if($role[0]->role == 'murid'){
            return redirect()->back()->with('status','Data murid berhasil di non aktifkan');
        }elseif($role == 'guru/staf'){
            return redirect()->back()->with('status','Data guru/staf berhasil di non aktifkan');
        }else{
            return redirect()->back()->with('status','Data murid berhasil di non aktifkan');
        }
    }

    public function getEditForm($users_id){
        $data =  User::find($users_id);

        $class = Classes::all();
        // dd($data);
        return view('user.editUserAdmin', compact('data','class'));
    }

    public function editDataUserAdmin(Request $request){
        $this->authorize('check-admin');
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

    public function getProfileUser($id){
        
        $data = User::find($id);
        // dd($data);
        return view('frontend.profile', compact('data'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'old-password' => ['required', 'string', 'min:8'],
            'new-password' => ['required', 'string', 'min:8'],
        ],
        [
            'old-password.required' => 'Kata sandi lama tidak boleh kosong',
            'new-password.required' => 'Kata sandi baru tidak boleh kosong',
            'min' => 'Kata sandi minimal 8 karakter'
        ]);
    }

    public function editPasswordUser(Request $request){
        $this->validator($request->all())->validate();

        $pwd = User::select('password')->where('id', '=', $request->get('id'))->get();
        // dd($pwd[0]->password);

        if (Hash::check($request->get('old-password'), $pwd[0]->password)) {
            $password_update = DB::table('users')
                        ->where('id', $request->get('id'))
                        ->update(['password' => Hash::make($request->get('new-password'))]);

            return redirect()->back()->with('status','Kata sandi berhasil diubah');
        }else{
            return redirect()->back()->with('error', 'Kata sandi lama tidak sesuai, masukkan kata sandi lama dengan benar');
        }
       
    }
}
