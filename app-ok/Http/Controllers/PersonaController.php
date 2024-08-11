<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Persona;
use App\Cliente;
use Illuminate\Support\Facades\Http;

class PersonaController extends Controller
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

        $empresas_All = Http::get("https://api-atom.cicbla.com/api/cliente.php");
        $empresas_array_All = $empresas_All->json();
        //dd();

        if($nombre=='' && $apellido=='' && $dni=='' && $empresa==''){
            $personas = Persona::orderBy('id','desc')->paginate(70);
        }
        else{
            $personas = Persona::where('nombre', 'like', '%'.$nombre.'%')->where('apellido', 'like', '%'.$apellido.'%')->
            where('dni', 'like', '%'.$dni.'%')->where('empresa', 'like', '%'.$empresa.'%')->orderBy('id','desc')->paginate(70);
        }

        return [
            'pagination' => [
                'total'         => $personas->total(),
                'current_page'  => $personas->currentPage(),
                'per_page'      => $personas->perPage(),
                'last_page'     => $personas->lastPage(),
                'from'          => $personas->firstItem(),
                'to'            => $personas->lastItem(),
            ],
            'personas'  =>  $personas,
            'empresas_all' => $empresas_array_All
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
        /*if($request->hasFile('perfil')){
            $file = $request->imagen('perfil');
            $name = time().$file->getClientOriginalName();
            $file->move(public_path(),$name);
        }
        return $request->all();*/


        /*
        $exploded =explode(';',$request->imagen);
        $decoded = base64_decode($exploded[1]);
        if(str_contains($exploded[0],'jpeg')){
            $extension = 'jpg';
        }
        else{
            $extension = 'png';
        }
        $fileName = 'Holaaaa.'.$extension;
        $path = public_path().$fileName;
        file_put_contents($path,$decoded);
        */
        //if(!$request->ajax())return redirect('/');

        $persona = new Persona();
        $persona->usuario_id = Auth::user()->id;
        $persona->nombre = $request->nombre;
        $persona->apellido = $request->apellido;
        $persona->dni = $request->dni;
        $persona->empresa = $request->empresa;
        $persona->email = $request->email;
        $persona->celular = $request->celular;
        $persona->grado_instruccion = $request->grado_instruccion;
        $persona->ip = $ip;
        $persona->cli_id = $request->cli_id;
        if($pathToFile==''){

        }
        else{
            $persona->imagen = $pathToFile;
        }
        $persona->condicion = '1';
        $persona->save();
        return $pathToFile;

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
        $persona->email = $request->email;
        $persona->celular = $request->celular;
        $persona->grado_instruccion = $request->grado_instruccion;
        $persona->ip = $request->ip;
        $persona->cli_id = $request->cli_id;
        if($pathToFile==''){

        }
        else{
            $persona->imagen = $pathToFile;
        }
        $persona->condicion = '1';
        $persona->save();
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
        $personas = Persona::join('clientes','clientes.id','=','personas.cli_id')->where('personas.dni','=', $filtro)->where('personas.condicion','=','1')->select('personas.id','personas.nombre','personas.apellido','personas.dni','clientes.cliente as empresa','personas.imagen','personas.cli_id')->orderBy('nombre','desc')->get();
        return ['personas' => $personas];
    }
    public function selectPersona(Request $request){
        if(!$request->ajax()) return redirect('/');
        $personas = Persona::where('condicion','=','1')
        ->select('id','nombre','apellido','dni','empresa')
        ->orderBy('nombre', 'asc')->get();
        return ['personas' => $personas];
    }

    public function personaCliId(Request $request, $cli_id)
    {
        $empresas = Http::get("https://api-atom.cicbla.com/api/cliente.php?id=$cli_id");
        $empresasArrays = $empresas->json();
        return $empresasArrays[0];
    }
}
