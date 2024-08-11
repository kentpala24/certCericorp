<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aprobacion_lote extends Model
{
    //protected $table = 'aprobacions';
    //  protected $primaryKey = 'id'; 
      protected $fillable = ['cantidad','condicion'];
      public function revision_lotes(){
        return $this->hasMany('App\Revision_lote');
      }
      public function solicitud_lote(){
        return $this->belongTo('App\Solicitud_lote');
      }
    }
