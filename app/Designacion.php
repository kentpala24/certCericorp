<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Designacion extends Model
{
    public function user(){
        return $this->belongTo('App\User');
    }
    
    public function tipo_certificado(){
        return $this->belongTo('App\Tipo_certificado');
    }
    
    public function carnes(){
        return $this->hasMany('App\Carne');
    }
}
