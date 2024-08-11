<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idrol', 'nombre', 'apellido','tipo_documento', 'numero_documento', 'telefono','email', 'ip', 'estado','usuario', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function rol(){
        return $this->belongTo('App\Rol');
    }

    public function solicitud_lotes(){
        return $this->hasMany('App\Solicitud_lote');
      }
      public function aprobacion_lotes(){
        return $this->hasMany('App\Aprobacion_lote');
    }
    public function revision_lotes(){
        return $this->hasMany('App\Revision_lote');
    }
    public function autorizacion_lotes(){
        return $this->hasMany('App\Autorizacion_lote');
    }
    public function firmas(){
        return $this->hasMany('App\Firma');
    }
    public function personas(){
        return $this->hasMany('App\Persona');
    }
    public function certificados(){
        return $this->hasMany('App\Certificado');
    }
    public function carnes(){
        return $this->hasMany('App\Carne');
    }
    public function designaciones(){
        return $this->hasMany('App\Designacion');
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
