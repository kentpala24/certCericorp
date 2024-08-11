<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    public function solicitud_lote(){
        return $this->belongTo('App\Solicitud_lote');
    }
}
