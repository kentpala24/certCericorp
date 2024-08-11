<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carne extends Model
{
    public function user(){
        return $this->belongTo('App\User');
    }
    public function designacion(){
        return $this->belongTo('App\Designacion');
    }
    public function certificado(){
        return $this->belongTo('App\Certificado');
    }
    
}
