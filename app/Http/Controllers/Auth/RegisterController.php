<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Classes;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/register';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('isAdmin');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ],
        [
            'name.required' => 'Nama pengguna tidak boleh kosong',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $this->authorize('check-admin');
        try{
            $nisn = NULL;
            $niy = NULL;
            $class_id = NULL;

            if($data['class_id'] != 0){
                $class_id = $data['class_id'];
            }

            if($data['role'] == 'murid'){
                $nisn = $data['nisn/niy'];
            }elseif($data['role'] == 'guru/staf'){
                $niy = $data['nisn/niy'];
            }

            User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'class_id' => $class_id,
                'nisn' => $nisn,
                'niy' =>$niy,
                'role' => $data['role'],
                'password' => Hash::make($data['password']),
            ]);
            
            if($data['role'] == 'murid'){
                return redirect()->guest(url('daftar-murid'))->with('status','Registrasi murid berhasil');
            }
            elseif($data['role'] == 'guru/staf'){
                return redirect()->guest(url('daftar-guru'))->with('status','Registrasi guru/staf berhasil');
            }else{
                return redirect()->guest(url('register'))->with('status','Registrasi admin berhasil');
            }
            
        }catch (\PDOException $e) {
            return redirect()->guest(url('register'))->with('error', 'Gagal registrasi pengguna, silahkan coba lagi');
        }  
        
    }

    public function showRegistrationForm(){
        $result = Classes::all();
        // dd($result);
        return view('auth.register', compact('result'));
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
