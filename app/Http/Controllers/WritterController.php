<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Writter;
use Illuminate\Support\Facades\Hash;

class WritterController extends Controller
{

    public function login()
    {
        return view('writter.login');
    }

    public function loginPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Email harus valid',
            'password.required' =>  'Password harus diisi'
        ]);


        $writter = Writter::where('email',$request->email)->first();

        if($writter){
            if(Hash::check($request->password,$writter->password)){
                session([
                    'loggedWritter' => true,
                    'writterId' => $writter->id
                ]);
                return redirect(route('writter.dashboard'));
            }else{
                return redirect()->back()->with('error','Email / Password Salah');
            }
        }else{
            return redirect()->back()->with('error','Email / Password Salah');
        }
    }

    public function dashboard()
    {
        return view('writter.dashboard');
    }

    public function logout()
    {
        session()->forget('loggedWritter');
        session()->forget('writterId');
        return redirect(route('writter.login'));
    }
}
