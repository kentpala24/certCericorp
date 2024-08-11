<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
use App\Rol;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        if(!$request->ajax()) return redirect('/');
        $buscar =$request->buscar;
        $criterio =$request->criterio;
        if($buscar==''){
            $roles = Rol::orderBy('id','desc')->paginate(10);
        }
        else{
            $roles= Rol::where($criterio,'like','%'.$buscar.'%')->orderBy('id','desc')->paginate(3);
        }


        return[
            'pagination' => [
                'total'          =>$roles->total(),
                'current_page'   =>$roles->currentPage(),
                'per_page'       =>$roles->perPage(),
                'last_page'      =>$roles->lastPage(),
                'from'           =>$roles->firstItem(),
                'to'             =>$roles->lastItem(),
            ],
            'roles' => $roles
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
    {
        if(!$request->ajax()) return redirect('/');
        $rol = new Rol();
        $rol->nombre=$request->nombre;
        $rol->descripcion=$request->descripcion;
        $rol->condicion='1';
        $rol->save();
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
    {
        if(!$request->ajax()) return redirect('/');
        $rol = Rol::findOrFail($request->id);
        $rol->nombre=$request->nombre;
        $rol->descripcion=$request->descripcion;
        $rol->condicion ='1';
        $rol->save();
    }
    public function desactivar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $rol = Rol::findOrFail($request->id);
        $rol->condicion ='0';
        $rol->save();
    }
    public function activar(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $rol = Rol::findOrFail($request->id);
        $rol->condicion ='1';
        $rol->save();
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
    public function selectRol(Request $request){
        if(!$request->ajax()) return redirect('/');
        $roles = Rol::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre','asc')->get();
        return ['roles' => $roles];
    }
}
