<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre','apellido','empresa','dni','email','celular','grado_instruccion','ip','imagen'];
    public function user(){
        return $this->belongTo('App\User');
    }
    public function certificados(){
        return $this->hasMany('App\Certificado');
    }
}
