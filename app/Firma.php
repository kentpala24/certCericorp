<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Firma extends Model
{
   // protected $table = 'roles';
    //  protected $primaryKey = 'id'; 
      protected $fillable = ['nombre','imagen','ip','condicion'];
      public function user(){
        return $this->belongTo('App\User');
    }
    public function certificados(){
      return $this->hasMany('App\Certificado');
  }
}
