<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tipo_Certificado extends Model
{
    protected $table = 'tipo_certificados';
    protected $fillable = ['nombre','condicion'];
    public function user(){
        return $this->belongTo('App\User');
    }
    public function certificados(){
        return $this->hasMany('App\Certificado');
    }
    public function designaciones(){
        return $this->hasMany('App\Designacion');
    }
}
