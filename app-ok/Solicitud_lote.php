<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Solicitud_lote extends Model
{
    protected $fillable = ['nombre','stock_actual','ultima_solicitud','cantidad','comentario'];
    
    public function user(){
        return $this->belongTo('App\User');
    }
    public function aprobacion_lotes(){
        return $this->hasMany('App\Aprobacion_lote');
    }

  
}
