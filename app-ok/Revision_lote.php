<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revision_lote extends Model
{
    //protected $table = 'revisions';
    //  protected $primaryKey = 'id'; 
      protected $fillable = ['condicion'];
      public function revision_lotes(){
        return $this->hasMany('App\Revision_lote');
      }
      public function aprobacion_lote(){
        return $this->belongTo('App\Aprobacion_lote');
      }
}
