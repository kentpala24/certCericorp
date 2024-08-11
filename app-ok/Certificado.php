<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model
{
    //
    public function user(){
        return $this->belongTo('App\User');
    }
    public function firma(){
        return $this->belongTo('App\Firma');
    }
    public function persona(){
        return $this->belongTo('App\Persona');
    }
    public function tipo_certificado(){
        return $this->belongTo('App\Tipo_certificado');
    }
    public function lote(){
        return $this->belongTo('App\Lote');
    }
    public function carnes(){
        return $this->hasMany('App\Carne');
    }
    
}
