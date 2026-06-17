<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function login(){
        return view('admin.auth.auth');
    }

    public function autenticar(Request $request){
         //dd('cheguei aqui');
 
        $request->validate([
            'email_usuario' =>  'required|email',
            'senha_usuario' => 'required',
        ]);

        $credenciais =[
            'email_usuario'=> $request-> email_usuario,
            'password' => $request-> senha_usuario,
            'perfil_usuario' => 'administrador',
        ];

        if(Auth::guard('admin')->attempt($credenciais)){
            $request -> session() -> regenerate();
            return redirect('admin');
        }

        return back() -> withInput()-> with('error' , 'Email ou Senha Invalida');
    }

    public function logout(Request $request){
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerate();

        return redirect()->route('admin.login');
    }
}
