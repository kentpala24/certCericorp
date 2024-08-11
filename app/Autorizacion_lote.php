<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Autorizacion_lote extends Model
{
    public function autorizacion_lotes(){
        return $this->hasMany('App\Autorizacion_lote');
    }
    public function revision_lote(){
        return $this->belongTo('App\Revision_lote');
    }
}
