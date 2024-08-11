<?php

namespace App\Http\Controllers;
Use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index(Request $request)
    {
        //if(!$request->ajax())return redirect('/');
        $nombre = $request->bnombre;
        $apellido = $request->bapellido;
        $dni = $request->bdni;
        $email = $request->bemail;
        $user = $request->buser;
        if($nombre=='' && $apellido=='' && $dni=='' && $email=='' && $user==''){
            $users = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.nombre','users.apellido',
            'users.tipo_documento','users.numero_documento','users.telefono','users.email','users.ip',
            'users.estado','users.usuario','users.password',
            'roles.nombre as rol','roles.id as idrol','users.updated_at')->orderBy('id','desc')->paginate(10);
        }
        else{
            $users = User::join('roles','users.idrol','=','roles.id')
            ->select('users.id','users.nombre','users.apellido',
            'users.tipo_documento','users.numero_documento','users.telefono','users.email','users.ip',
            'users.estado','users.usuario','users.password',
            'roles.nombre as rol','roles.id as idrol','users.updated_at')->
            where('users.nombre', 'like', '%'.$nombre.'%')->where('users.apellido', 'like', '%'.$apellido.'%')->
            where('users.numero_documento', 'like', '%'.$dni.'%')->where('users.email', 'like', '%'.$email.'%')
            ->where('users.usuario', 'like', '%'.$user.'%')->orderBy('id','desc')->paginate(10);
        }

        return [
            'pagination' => [
                'total'         => $users->total(),
                'current_page'  => $users->currentPage(),
                'per_page'      => $users->perPage(),
                'last_page'     => $users->lastPage(),
                'from'          => $users->firstItem(),
                'to'            => $users->lastItem(),
            ],
            'users'  =>  $users
        ];
    }

    public function store(Request $request)
    {
        if(!$request->ajax())return redirect('/');
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
      
            $user = new User();
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->tipo_documento = $request->tipo_documento;
            $user->numero_documento = $request->numero_documento;
            $user->telefono = $request->telefono;
            $user->email = $request->email;
            $user->ip = $ip;
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->idrol = $request->idrol;
            $user->estado = '1';
            $user->save();
        
        
    }

    public function update(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        
            $user = User::findOrFail($request->id);
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->tipo_documento = $request->tipo_documento;
            $user->numero_documento = $request->numero_documento;
            $user->telefono = $request->telefono;
            $user->email = $request->email;
            $user->ip = '192.168.1.1';
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->idrol = $request->idrol;
            $user->estado = '1';
            $user->save();
        

    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
