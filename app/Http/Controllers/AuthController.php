<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $email=$request->email;
        $password=$request->password;
        $credentials = [
            'email' => $email,
            'password' => $password
        ];

        $cekuser_status=User::where('email',$email)->first();

        $dologin=Auth::attempt($credentials);

        //dd($dologin);

        if($dologin){
            return redirect('/home');
        }
        else{
            return redirect('/')->with('statusLogin','Wrong Email or Password');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('statusLogout','Success Logout');
    }

}
