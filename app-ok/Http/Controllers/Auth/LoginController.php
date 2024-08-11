<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Autentificate;
use App\User;

class LoginController extends Controller
{
   public function showLoginForm(){
       return view('auth.login');
    
   }

   public function login(Request $request){
    $this->validateLogin($request);
    if(Auth::attempt(['usuario' => $request->usuario,'password' => $request->password,'estado'=>1])){
     if (getenv('HTTP_CLIENT_IP')) {
         $ip = getenv('HTTP_CLIENT_IP');
       } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
         $ip = getenv('HTTP_X_FORWARDED_FOR');
       } elseif (getenv('HTTP_X_FORWARDED')) {
         $ip = getenv('HTTP_X_FORWARDED');
       } elseif (getenv('HTTP_FORWARDED_FOR')) {
         $ip = getenv('HTTP_FORWARDED_FOR');
       } elseif (getenv('HTTP_FORWARDED')) {
         $ip = getenv('HTTP_FORWARDED');
       } else {
         // Método por defecto de obtener la IP del usuario
         // Si se utiliza un proxy, esto nos daría la IP del proxy
         // y no la IP real del usuario.
         $ip = $_SERVER['REMOTE_ADDR'];
       }
     $autentificate = new Autentificate();
     $autentificate->idusuario=Auth::user()->id;
     $autentificate->ip=$ip;
     $autentificate->save();   
     $user = User::findOrFail(Auth::user()->id);
     $user->ip =rand(1, 10000);
     $user->save();
     return redirect()->route('main');
    }
    return back()
    ->withErrors(['usuario' => trans('auth.failed')])
    ->withInput(request(['usuario']));
   }
   protected function validateLogin(Request $request){
    $this->validate($request,[
        'usuario' => 'required|string',
        'password' => 'required|string'
    ]);
   }
   public function logout(Request $request){
       Auth::logout();
       $request->session()->invalidate();
       return redirect('/');
   }
}
