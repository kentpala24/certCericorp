<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Cliente;
use App\User;
use DB;
use Illuminate\Support\Facades\Http;

class PersonaCertificaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if(!$request->ajax())return redirect('/');
        $nombre = $request->bnombre;
        $apellido = $request->bapellido;
        $dni = $request->bdni;
        $empresa = $request->bempresa;
        //dd($empresa);

        if($nombre=='' && $apellido=='' && $dni=='' && $empresa==''){
            $personas = Persona::
            Join('users as u', 'u.id', '=', 'personas.usua_web')->select('personas.nombre', 'u.usuario')
            ->orderBy('personas.id','desc')->where('personas.condicion','=','1')->paginate(70);
        }
        else{
            /*$personas = Persona::
            leftJoin('users as u', 'u.id', '=', 'personas.usua_web')->select('personas.*', 'u.usuario')
            ->where('personas.nombre', 'like', '%'.$nombre.'%')->where('personas.apellido', 'like', '%'.$apellido.'%')->
            where('.personas.dni', 'like', '%'.$dni.'%')->where('personas.cli_id', '=', ''.$empresa.'')->where('personas.condicion','=','1')->orderBy('personas.id','desc')->paginate(70);*/
            $personas = DB::table('personas')
            ->leftJoin('users as u', 'u.id', '=', 'personas.usua_web')
            ->select(DB::raw('personas.*'), 'u.usuario')
            ->where('personas.nombre', 'like', '%' . $nombre . '%')
            ->where('personas.apellido', 'like', '%' . $apellido . '%')
            ->where('personas.dni', 'like', '%' . $dni . '%')
            ->where('personas.cli_id', $empresa)
            ->where('personas.condicion', 1)
            ->orderBy('personas.id','desc')->paginate(70);
            //dd($personas);
        }
        //dd($personas);
        return [
            'pagination' => [
                'total'         => $personas->total(),
                'current_page'  => $personas->currentPage(),
                'per_page'      => $personas->perPage(),
                'last_page'     => $personas->lastPage(),
                'from'          => $personas->firstItem(),
                'to'            => $personas->lastItem(),
            ],
            'personas'  =>  $personas
        ];
    }
    public function indexCliente(Request $request)
    {
        //if(!$request->ajax())return redirect('/');
        $nombre = $request->nombre;
        $ruc = $request->ruc;
        $codigo = $request->codigo;
        $iniciales = $request->iniciales;


        if($nombre=='' && $ruc=='' && $codigo=='' && $iniciales==''){
            $cliente = Cliente::orderBy('id','desc')->paginate(70);
        }
        else{
            $cliente = Cliente::where('cliente', 'like', '%'.$nombre.'%')->where('ruc_cliente', 'like', '%'.$ruc.'%')->
            where('codigo_cliente', 'like', '%'.$codigo.'%')->where('iniciales_cliente', 'like', '%'.$iniciales.'%')->orderBy('id','desc')->paginate(70);
        }

        return [
            'pagination' => [
                'total'         => $cliente->total(),
                'current_page'  => $cliente->currentPage(),
                'per_page'      => $cliente->perPage(),
                'last_page'     => $cliente->lastPage(),
                'from'          => $cliente->firstItem(),
                'to'            => $cliente->lastItem(),
            ],
            'cliente'  =>  $cliente
        ];
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
    {   if(!$request->ajax()) return redirect('/');
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

        if($request->hasFile('image')){
            $name = time().$request->file('image')->getClientOriginalName();
            $pathToFile = $request->file('image')->storeAs('images',$name,'public');
        }
        else{
            $pathToFile='';
        }
        
        $persona = new Persona();
        $persona->usuario_id = Auth::user()->id;
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->dni = $request->dni;
        //dd($request->all());
        $persona->cli_id = $request->cli_id;
        //dd($request->cli_id);
        $persona->email = $request->email;
        $persona->celular = $request->celular;

        //$persona->grado_instruccion = $request->grado_instruccion;
        $persona->ip = $ip;
        $persona->sede = 2;
        if($pathToFile==''){

        }
        else{
            $persona->imagen = $pathToFile;
        }
        $persona->condicion = '1';
        
        if($request->indiUsua=="2"){
            $user = new User();
            $user->nombre = $request->nombre;
            $user->apellido = $request->apellido;
            $user->tipo_documento = 'DNI';
            $user->numero_documento = $request->dni;
            $user->telefono = $request->celular;
            $user->email = $request->email;
            $user->estado = "1";
            $user->idrol = 6;
            $user->ip = $ip;
            $user->usuario = $request->usuario;
            $user->password = bcrypt($request->password);
            $user->save();
        }
        $persona->usua_web = $user->id;
        $persona->save();
        return $pathToFile;

    }
    public function storeCliente(Request $request)
    {   if(!$request->ajax()) return redirect('/');
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

        
        $cliente = new Cliente();
        $cliente->cliente = $request->cliente;
        $cliente->ruc_cliente = $request->ruc;
        $cliente->codigo_cliente = $request->codigo;
        $cliente->iniciales_cliente = $request->iniciales;
        $cliente->ip = $ip;
        
        $cliente->condicion = '1';
        $cliente->save();
        return "Ok";

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {   if(!$request->ajax()) return redirect('/');
        if($request->hasFile('image')){
            $name = time().$request->file('image')->getClientOriginalName();
            $pathToFile = $request->file('image')->storeAs('images',$name,'public');
        }
        else{
            $pathToFile='';
        }
        if(!$request->ajax())return redirect('/');
        $persona = Persona::findOrFail($request->id);
        $persona->usuario_id = 1;
        $persona->nombre = $request->nombre;
        $persona->empresa = $request->empresa;
        $persona->apellido = $request->apellido;
        $persona->dni = $request->dni;
        //$persona->email = $request->email;
        $persona->celular = $request->celular;
        //$persona->grado_instruccion = $request->grado_instruccion;
        //$persona->ip = $request->ip;
        if($pathToFile==''){

        }
        else{
            $persona->imagen = $pathToFile;
        }
        $persona->condicion = '1';
        if($request->indiUsua=="2"){
            if($persona->usua_web==null){
                $user = new User();
                $user->nombre = $request->nombre;
                $user->apellido = $request->apellido;
                $user->tipo_documento = 'DNI';
                $user->numero_documento = $request->dni;
                $user->telefono = $request->celular;
                $user->email = $request->email;
                $user->estado = "1";
                $user->usuario = $request->usuario;
                $user->password = bcrypt($request->password);
                $user->save();
                $persona->usua_web = $user->id;
            }
            else{
                $user = User::find($persona->usua_web);
                $user->nombre = $request->nombre;
                $user->apellido = $request->apellido;
                $user->tipo_documento = 'DNI';
                $user->numero_documento = $request->dni;
                $user->telefono = $request->celular;
                $user->email = $request->email;
                $user->estado = "1";
                $user->usuario = $request->usuario;
                $user->password = bcrypt($request->password);
                $user->update();
            }
            
                
                $persona->save();
            
        }
    }

    public function desactivar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $persona = Persona::findOrFail($request->id);
        $persona->condicion = '0';
        $persona->save();
    }

    public function activar(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $persona = Persona::findOrFail($request->id);
        $persona->condicion = '1';
        $persona->save();
    }
    public function updateCliente(Request $request)
    {   if(!$request->ajax()) return redirect('/');
        
        $cliente = Cliente::findOrFail($request->id);
        $cliente->cliente = $request->cliente;
        $cliente->ruc_cliente = $request->ruc;
        $cliente->codigo_cliente = $request->codigo;
        $cliente->iniciales_cliente = $request->iniciales;
        //$cliente->ip = $ip;
        $cliente->condicion = '1';
        $cliente->save();
    }

    public function desactivarCliente(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->condicion = '0';
        $cliente->save();
    }

    public function activarCliente(Request $request)
    {
        if(!$request->ajax())return redirect('/');
        $cliente = Cliente::findOrFail($request->id);
        $cliente->condicion = '1';
        $cliente->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function buscarPersona(Request $request)
    {   //if(!$request->ajax()) return redirect('/');
        $filtro = $request->filtro;
        $personas = Persona::where('dni','=', $filtro)->where('condicion','=','1')->select('id','nombre','apellido','dni','empresa','imagen','cli_id')->orderBy('nombre','desc')->get();
        return ['personas' => $personas];
    }
    public function selectPersona(Request $request){
        if(!$request->ajax()) return redirect('/');
        $personas = Persona::where('condicion','=','1')
        ->select('id','nombre','apellido','dni','empresa')
        ->orderBy('nombre', 'asc')->get();
        return ['personas' => $personas];
    }

    public function selectCliente(Request $request){
        if(!$request->ajax()) return redirect('/');
        $clientes = Cliente::where('condicion','=','1')
        ->select('id','cliente','ruc_cliente')
        ->orderBy('cliente', 'asc')->get();
        return ['clientes' => $clientes];
    }

    public function personaCliId(Request $request, $cli_id)
    {
        $empresas = Http::get("https://api-atom.cicbla.com/api/cliente.php?id=$cli_id");
        $empresasArrays = $empresas->json();
        return $empresasArrays[0];
    }
}
