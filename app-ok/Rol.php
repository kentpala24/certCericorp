<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table = 'roles';
  //  protected $primaryKey = 'id'; 
    protected $fillable = ['nombre','descripcion','condicion'];

    public function users(){
      return $this->hasMany('App\User');
    }
}
