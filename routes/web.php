<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['middleware'=>['guest']],function(){
//Login
    Route::get('/', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
    Route::get('/search','ValidacionController@search');
    Route::get('/api-cert','ValidacionController@apiCert');
    Route::get('/api-serv','ValidacionController@apiServ');
    Route::get('/api-expe','ValidacionController@apiExpe');
    Route::get('/api-cert-pers','ValidacionController@apiCertPers');
    Route::get('/api-cert-empr','ValidacionController@apiCertEmpr');
    Route::get('/searcheq','ValidacionController@searcheq');
    Route::get('/verificar','ValidacionController@validacion');
    Route::get('/verificarEquipo','ValidacionController@validacioneq');
});

Route::group(['middleware'=>['auth']],function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::GET('/dashboard', 'DashboardController');
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');
    Route::group(['middleware'=>['Administrador']],function(){
        //Storage:link
        Route::GET('storage-link', function(){
            Artisan::call('storage:link');
        });
        //Gestión de Roles
        Route::get('/rol', 'RolController@index');
        Route::post('/rol/registrar', 'RolController@store');
        Route::put('/rol/actualizar', 'RolController@update');
        Route::put('/rol/desactivar', 'RolController@desactivar');
        Route::put('/rol/activar', 'RolController@activar');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        //Gestión de Lote
        Route::get('/lote', 'LoteController@index');
        Route::post('/lote/registrar', 'LoteController@store');
        Route::put('/lote/actualizar', 'LoteController@update');
        Route::put('/lote/desactivar', 'LoteController@desactivar');
        Route::put('/lote/activar', 'LoteController@activar');
        Route::get('/lote/selectLote', 'LoteController@selectLote');
        //gestion de solicitud de lotes 
        Route::get('/solicitud', 'SolicitudlotesController@index');
        Route::post('/solicitud/registrar', 'SolicitudlotesController@store');
        Route::put('/solicitud/actualizar', 'SolicitudlotesController@update');
        Route::put('/solicitud/desactivar', 'SolicitudlotesController@desactivar');
        Route::put('/solicitud/activar', 'SolicitudlotesController@activar');
        //gestion de aprobacion 
        Route::get('/aprobacion', 'AprobacionController@index');
        Route::post('/aprobacion/registrar', 'AprobacionController@store');
        Route::post('/aprobacion/actualizar', 'AprobacionController@update');
        Route::put('/aprobacion/desactivar', 'AprobacionController@desactivar');
        Route::put('/aprobacion/activar', 'AprobacionController@activar');
        //gestion de autorizacion
        Route::get('/autorizacion', 'AutorizacionController@index');
        Route::post('/autorizacion/registrar', 'AutorizacionController@store');
        Route::post('/autorizacion/actualizar', 'AutorizacionController@update');
        Route::put('/autorizacion/desactivar', 'AutorizacionController@desactivar');
        Route::put('/autorizacion/activar', 'AutorizacionController@activar');
        //Gestión de Usuarios
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');
        //Gestión de Personas
        Route::get('/persona', 'PersonaController@index');
        Route::post('/persona/registrar', 'PersonaController@store');
        Route::post('/persona/actualizar', 'PersonaController@update');
        Route::put('/persona/desactivar', 'PersonaController@desactivar');
        Route::put('/persona/activar', 'PersonaController@activar');
        Route::get('/persona/selectPersona', 'PersonaController@selectPersona');
        Route::get('/persona/buscarPersona', 'PersonaController@buscarPersona');
        //Gestión de Revalidación
        /*Route::get('/revalidacion', 'RevalidacionController@revalidacion');
        Route::put('/revalidacion/carne', 'RevalidacionController@store');
        Route::put('/revalidacion/carneactualizar', 'RevalidacionController@update');
        Route::put('/revalidacion/carneactualizarA', 'RevalidacionController@updateA');
        Route::put('/revalidacion/emitircarne', 'RevalidacionController@emitir');
        Route::put('/revalidacion/desactivar', 'RevalidacionController@desactivar');
        Route::put('/revalidacion/activar', 'RevalidacionController@activar');
        Route::get('/revalidacion/carnePdf/{id}', 'RevalidacionController@carnePdf');
        Route::get('/revalidacion/carnePdfEmision1/{id}', 'RevalidacionController@carneEmisionPdf1'); */
        //Gestión de Equipo
        Route::get('/equipo', 'EquipoController@index');
        Route::get('/equipoC', 'EquipoController@indexCliente');
        Route::put('/equipo/registrar', 'EquipoController@store');
        Route::post('/equipo/actualizar', 'EquipoController@update');
        Route::put('/equipo/desactivar', 'EquipoController@desactivar');
        Route::put('/equipo/activar', 'EquipoController@activar');
        Route::get('/equipo/certificadoPdfEmision/{id}', 'EquipoController@certificadoPdfEmision'); 
        Route::get('/equipo/certificadoPdfEmisionSF/{id}', 'EquipoController@certificadoPdfEmisionSinFondo'); 
        //Route::get('/equipo/certificadoPdfEmisionSF/{id}', 'EquipoController@certificadoPdfEmisionSinFondo');
        Route::put('/equipo/generateCerti', 'EquipoController@emitirCertificado');
        Route::get('/equipo/certificadoPdf/{id}', 'EquipoController@certificadoPdf'); 
        
        //Gestión de Certificado
        Route::get('/consulta', 'CertificadoController@listado');
        Route::get('/consulta2', 'CertificadoController@listado2');
        Route::post('/certificado/registrar', 'CertificadoController@store');
        Route::put('/certificado/generateCerti', 'CertificadoController@generateCerti');
        Route::put('/certificado/generateCerti1', 'CertificadoController@generateCerti1');
        Route::put('/certificado/actualizar', 'CertificadoController@update');
        Route::put('/certificado/actualizarad', 'CertificadoController@updatead');
        Route::put('/certificado/desactivar', 'CertificadoController@desactivar');
        Route::put('/certificado/activar', 'CertificadoController@activar');
        Route::get('/certificado/certificadoPdf/{id}', 'CertificadoController@certificadoPdf'); 
        Route::get('/certificado/certificadoPdfEmisionSinFondo/{id}', 'CertificadoController@certificadoPdfEmisionSinFondo'); 
        Route::get('/codigoqr', 'CertificadoController@codigoqr'); 
        Route::post('/certificado/edicion', 'CertificadoController@edicion');
        Route::get('/edicioncerti', 'CertificadoController@edicioncerti');
        Route::post('/edicion/desaprobar', 'CertificadoController@desaprobar');
        Route::post('/edicion/aprobar', 'CertificadoController@aprobar');
       
        
        //Gestion de Carne
        Route::put('/carne/actualizar', 'CertificadoController@actualizarCarne');
        Route::put('/carne/emitir', 'CertificadoController@emitirCarne');
        Route::put('/carne/emitir1', 'CertificadoController@emitirCarne1');
        Route::post('/carne/revalidacion', 'CarneController@store');
        Route::get('/carne/carnePdf/{id}', 'CarneController@carnePdf'); 
        Route::get('/carne/carnePdfEmision/{id}', 'CarneController@carneEmisionPdf'); 
        Route::get('/carne/carnePdfEmision1/{id}', 'CarneController@carneEmisionPdf1'); 

        //Generar Carne
        Route::put('/emitir/Carne', 'CarneController@emiCard'); 
        Route::put('/carne/update', 'CarneController@actualizarCarne'); 

        //Gestión de Firma
        Route::get('/firma', 'FirmaController@index');
        Route::post('/firma/registrar', 'FirmaController@store');
        Route::post('/firma/actualizar', 'FirmaController@update');
        Route::put('/firma/desactivar', 'FirmaController@desactivar');
        Route::put('/firma/activar', 'FirmaController@activar');
        Route::get('/firma/selectFirma', 'FirmaController@selectFirma');

        //Tipo de Equipo
        Route::get('/tipoEquipo', 'TipoEquipoController@index');
        Route::post('/tipoEquipo/registrar', 'TipoEquipoController@store');
        Route::post('/tipoEquipo/actualizar', 'TipoEquipoController@update');
        Route::put('/tipoEquipo/desactivar', 'TipoEquipoController@desactivar');
        Route::put('/tipoEquipo/activar', 'TipoEquipoController@activar');
        Route::get('/tipoEquipo/selectTipoEquipo', 'TipoEquipoController@selectTipoEquipo');

        //Datos de Equipo
        Route::get('/datoEquipo', 'DatoEquipoController@index');
        Route::post('/datoEquipo/registrar', 'DatoEquipoController@store');
        Route::post('/datoEquipo/actualizar', 'DatoEquipoController@update');
        Route::put('/datoEquipo/desactivar', 'DatoEquipoController@desactivar');
        Route::put('/datoEquipo/activar', 'DatoEquipoController@activar');
        Route::get('/clientes/selectCliente', 'PersonaCertificaController@selectCliente');
        Route::get('/datoEquipo/selectEquipos', 'DatoEquipoController@selectEquipos');

        //Gestión de Designacion
        Route::get('/designacion', 'DesignacionController@designacion');
        Route::post('/designacion/registrar', 'DesignacionController@store');
        Route::post('/designacion/actualizar', 'DesignacionController@update');
        Route::put('/designacion/desactivar', 'DesignacionController@desactivar');
        Route::put('/designacion/activar', 'DesignacionController@activar');
        Route::get('/designacion/selectDesignacion', 'DesignacionController@selectDesignacion');
        Route::get('/designacion/buscarDesignacion', 'DesignacionController@buscarDesignacion');

        //Gestión de Tipo de Certificado
        Route::get('/tipo', 'Tipo_CertificadoController@index');
        Route::post('/tipo/registrar', 'Tipo_CertificadoController@store');
        Route::put('/tipo/actualizar', 'Tipo_CertificadoController@update');
        Route::put('/tipo/desactivar', 'Tipo_CertificadoController@desactivar');
        Route::put('/tipo/activar', 'Tipo_CertificadoController@activar');
        Route::get('/tipo/selectTipo_Certificado', 'Tipo_CertificadoController@selectTipo_Certificado');
        //Gestión de Servicios
        Route::get('/servicios', 'ServicioController@index');
        //
        //ISO 17024 
        //Cliente
        Route::get('/cliente', 'PersonaCertificaController@indexCliente');
        Route::post('/cliente/registrar', 'PersonaCertificaController@storeCliente');
        Route::post('/cliente/actualizar', 'PersonaCertificaController@updateCliente');
        Route::put('/cliente/desactivar', 'PersonaCertificaController@desactivarCliente');
        Route::put('/cliente/activar', 'PersonaCertificaController@activarCliente');        
        //Persona
        Route::get('/personaC', 'PersonaCertificaController@index');
        Route::post('/personaC/registrar', 'PersonaCertificaController@store');
        Route::post('/personaC/actualizar', 'PersonaCertificaController@update');
        Route::put('/personaC/desactivar', 'PersonaCertificaController@desactivar');
        Route::put('/personaC/activar', 'PersonaCertificaController@activar');
        Route::get('/personaC/selectPersona', 'PersonaCertificaController@selectPersona');
        Route::get('/personaC/buscarPersona', 'PersonaCertificaController@buscarPersona');
        //Gestión de Designacion
        Route::get('/designacionC', 'DesignacionCertificaController@designacion');
        Route::post('/designacionC/registrar', 'DesignacionCertificaController@store');
        Route::post('/designacionC/actualizar', 'DesignacionCertificaController@update');
        Route::put('/designacionC/desactivar', 'DesignacionCertificaController@desactivar');
        Route::put('/designacionC/activar', 'DesignacionCertificaController@activar');
        Route::get('/designacionC/selectDesignacion', 'DesignacionCertificaController@selectDesignacion');
        Route::get('/designacionC/buscarDesignacion', 'DesignacionCertificaController@buscarDesignacion'); 
        //Otros
        Route::get('/lote/selectLoteUnico', 'LoteController@selectLoteUnico');
        Route::get('/firma/selectFirmaBo', 'FirmaController@selectFirmaBo');
        Route::get('/tipo/selectTipoCCertifica', 'Tipo_CertificadoController@selectTipoCCertifica');
        //Fin otros
        //Gestión de Certificado
        Route::get('/consulta3', 'CertificadoCertificaController@listado2');
        Route::get('/consultaCerti', 'CertificadoCertificaController@listado');
        Route::get('/consultaCertiCliente', 'CertificadoCertificaController@listadoCliente');
        Route::get('/consultaCerti2', 'CertificadoCertificaController@listado2');
        Route::post('/certificadoC/registrar', 'CertificadoCertificaController@store');
        Route::put('/certificadoC/generateCerti', 'CertificadoCertificaController@generateCerti');
        Route::put('/certificadoC/generateCerti1', 'CertificadoCertificaController@generateCerti1');
        Route::post('/certificadoC/actualizar', 'CertificadoCertificaController@update');
        Route::put('/certificadoC/actualizar1', 'CertificadoCertificaController@update1');//KPS
        Route::put('/certificadoC/actualizarad', 'CertificadoCertificaController@updatead');
        Route::put('/certificadoC/desactivar', 'CertificadoCertificaController@desactivar');
        Route::put('/certificadoC/activar', 'CertificadoCertificaController@activar');
        Route::get('/certificadoC/certificadoPdf/{id}', 'CertificadoCertificaController@certificadoPdf'); 
        Route::get('/certificadoC/certificadoPdfEmision/{id}', 'CertificadoCertificaController@certificadoPdfEmision'); 
        Route::get('/certificadoC/certificadoPdfEmisionSinFondo/{id}', 'CertificadoCertificaController@certificadoPdfEmisionSinFondo'); 
        Route::get('/codigoqr', 'CertificadoController@codigoqr'); 
        Route::post('/certificado/edicion', 'CertificadoController@edicion');
        Route::post('/certificadoC/edicion', 'CertificadoController@edicion');
        Route::get('/edicioncerti', 'CertificadoController@edicioncerti');
        Route::post('/edicion/desaprobar', 'CertificadoController@desaprobar');
        Route::post('/edicion/aprobar', 'CertificadoController@aprobar');
        //Gestion de Carne
        Route::put('/carneC/actualizar', 'CertificadoCertificaController@actualizarCarne');
        Route::put('/carneC/emitir', 'CertificadoCertificaController@emitirCarne');
        Route::put('/carneC/emitir1', 'CertificadoCertificaController@emitirCarne1');
        Route::post('/carneC/revalidacion', 'CarneCertificaController@store');
        Route::get('/carneC/carnePdf/{id}', 'CarneCertificaController@carnePdf'); 
        Route::get('/carneC/carnePdfEmision/{id}', 'CarneCertificaController@carneEmisionPdf'); 
        Route::get('/carneC/carnePdfEmision1/{id}', 'CarneCertificaController@carneEmisionPdf1'); 
        //Generar Carne
        Route::put('/emitir/Carne', 'CarneController@emiCard'); 
        Route::put('/carne/update', 'CarneController@actualizarCarne'); 
        //Gestión de Firma
        Route::get('/firmaC', 'FirmaCertificaController@index');
        Route::post('/firmaC/registrar', 'FirmaCertificaController@store');
        Route::post('/firmaC/actualizar', 'FirmaCertificaController@update');
        Route::put('/firmaC/desactivar', 'FirmaCertificaController@desactivar');
        Route::put('/firmaC/activar', 'FirmaCertificaController@activar');
        Route::get('/firmaC/selectFirma', 'FirmaCertificaController@selectFirma');  
        //FIN ISO 17024
    });

    Route::group(['middleware'=>['Aprobador']],function(){
        //Gestión de Lote
        Route::get('/lote', 'LoteController@index');
        Route::post('/lote/registrar', 'LoteController@store');
        Route::put('/lote/actualizar', 'LoteController@update');
        Route::put('/lote/desactivar', 'LoteController@desactivar');
        Route::put('/lote/activar', 'LoteController@activar');
        Route::get('/lote/selectLote', 'LoteController@selectLote');
        //Solicitud de Lote
        Route::get('/solicitud', 'SolicitudlotesController@index');
        Route::post('/solicitud/registrar', 'SolicitudlotesController@store');
        Route::put('/solicitud/actualizar', 'SolicitudlotesController@update');
        Route::put('/solicitud/desactivar', 'SolicitudlotesController@desactivar');
        Route::put('/solicitud/activar', 'SolicitudlotesController@activar');
        //gestion de aprobacion 
        Route::get('/aprobacion', 'AprobacionController@index');
        Route::post('/aprobacion/registrar', 'AprobacionController@store');
        Route::post('/aprobacion/actualizar', 'AprobacionController@update');
        Route::put('/aprobacion/desactivar', 'AprobacionController@desactivar');
        Route::put('/aprobacion/activar', 'AprobacionController@activar');
    });

    Route::group(['middleware'=>['Revisor']],function(){
        //Gestión de Lote
        Route::get('/lote', 'LoteController@index');
        Route::post('/lote/registrar', 'LoteController@store');
        Route::put('/lote/actualizar', 'LoteController@update');
        Route::put('/lote/desactivar', 'LoteController@desactivar');
        Route::put('/lote/activar', 'LoteController@activar');
        Route::get('/lote/selectLote', 'LoteController@selectLote');

    });
    Route::group(['middleware'=>['Autorizador']],function(){
            //gestion de autorizacion
        Route::get('/autorizacion', 'AutorizacionController@index');
        Route::post('/autorizacion/registrar', 'AutorizacionController@store');
        Route::post('/autorizacion/actualizar', 'AutorizacionController@update');
        Route::put('/autorizacion/desactivar', 'AutorizacionController@desactivar');
        Route::put('/autorizacion/activar', 'AutorizacionController@activar');

        });
    Route::group(['middleware'=>['Certificaciones']],function(){
        //Gestión de Personas
        Route::get('/persona', 'PersonaController@index');
        Route::post('/persona/registrar', 'PersonaController@store');
        Route::put('/persona/actualizar', 'PersonaController@update');
        Route::put('/persona/desactivar', 'PersonaController@desactivar');
        Route::put('/persona/activar', 'PersonaController@activar');
        //Solicitud de Lote
        Route::get('/solicitud', 'SolicitudlotesController@index');
        Route::post('/solicitud/registrar', 'SolicitudlotesController@store');
        Route::put('/solicitud/actualizar', 'SolicitudlotesController@update');
        Route::put('/solicitud/desactivar', 'SolicitudlotesController@desactivar');
        Route::put('/solicitud/activar', 'SolicitudlotesController@activar');
        //Gestión de Personas
        Route::get('/persona', 'PersonaController@index');
        Route::post('/persona/registrar', 'PersonaController@store');
        Route::post('/persona/actualizar', 'PersonaController@update');
        Route::put('/persona/desactivar', 'PersonaController@desactivar');
        Route::put('/persona/activar', 'PersonaController@activar');
        Route::get('/persona/selectPersona', 'PersonaController@selectPersona');
        Route::get('/persona/buscarPersona', 'PersonaController@buscarPersona');
        //Gestión de Certificado
        Route::get('/consulta', 'CertificadoController@listado');
        Route::post('/certificado/registrar', 'CertificadoController@store');
        Route::put('/certificado/generateCerti', 'CertificadoController@generateCerti');
        Route::put('/certificado/actualizar', 'CertificadoController@update');
        Route::put('/certificado/actualizar1', 'CertificadoController@update1');
        Route::put('/certificado/desactivar', 'CertificadoController@desactivar');
        Route::put('/certificado/activar', 'CertificadoController@activar');
        Route::get('/certificado/certificadoPdf/{id}', 'CertificadoController@certificadoPdf'); 
        
        Route::get('/certificado/certificadoPdfEmisionSinFondo/{id}', 'CertificadoController@certificadoPdfEmisionSinFondo'); 
        Route::get('/codigoqr', 'CertificadoController@codigoqr'); 
        //Gestion de Carne
        Route::put('/carne/actualizar', 'CertificadoController@actualizarCarne');
        Route::put('/carne/emitir', 'CertificadoController@emitirCarne');
        Route::put('/carne/emitir1', 'CertificadoController@emitirCarne1');
        Route::post('/carne/revalidacion', 'CarneController@store');
        Route::get('/carne/carnePdf/{id}', 'CarneController@carnePdf'); 
        Route::get('/carne/carnePdfEmision/{id}', 'CarneController@carneEmisionPdf'); 
        Route::get('/carne/carnePdfEmision1/{id}', 'CarneController@carneEmisionPdf1'); 

        //Generar Carne
        Route::put('/emitir/Carne', 'CarneController@emiCard'); 
        Route::put('/carne/update', 'CarneController@actualizarCarne'); 
        //ISO 17024 
        //Persona
        Route::get('/personaC', 'PersonaCertificaController@index');
        Route::post('/personaC/registrar', 'PersonaCertificaController@store');
        Route::post('/personaC/actualizar', 'PersonaCertificaController@update');
        Route::put('/personaC/desactivar', 'PersonaCertificaController@desactivar');
        Route::put('/personaC/activar', 'PersonaCertificaController@activar');
        Route::get('/personaC/selectPersona', 'PersonaCertificaController@selectPersona');
        Route::get('/personaC/buscarPersona', 'PersonaCertificaController@buscarPersona');
        //Gestión de Designacion
        Route::get('/designacionC', 'DesignacionCertificaController@designacion');
        Route::post('/designacionC/registrar', 'DesignacionCertificaController@store');
        Route::post('/designacionC/actualizar', 'DesignacionCertificaController@update');
        Route::put('/designacionC/desactivar', 'DesignacionCertificaController@desactivar');
        Route::put('/designacionC/activar', 'DesignacionCertificaController@activar');
        Route::get('/designacionC/selectDesignacion', 'DesignacionCertificaController@selectDesignacion');
        Route::get('/designacionC/buscarDesignacion', 'DesignacionCertificaController@buscarDesignacion'); 
        //Otros
        Route::get('/lote/selectLoteUnico', 'LoteController@selectLoteUnico');
        Route::get('/firma/selectFirmaBo', 'FirmaController@selectFirmaBo');
        Route::get('/tipo/selectTipoCCertifica', 'Tipo_CertificadoController@selectTipoCCertifica');
        //Fin otros
        //Gestión de Certificado
        Route::get('/consultaCerti', 'CertificadoCertificaController@listado');
        Route::get('/consultaCerti2', 'CertificadoCertificaController@listado2');
        Route::post('/certificadoC/registrar', 'CertificadoCertificaController@store');
        Route::put('/certificadoC/generateCerti2', 'CertificadoCertificaController@generateCerti');
        Route::put('/certificadoC/generateCerti1', 'CertificadoCertificaController@generateCerti1');
        Route::put('/certificadoC/actualizar', 'CertificadoCertificaController@update');
        Route::put('/certificadoC/actualizarad', 'CertificadoCertificaController@updatead');
        Route::put('/certificadoC/desactivar', 'CertificadoCertificaController@desactivar');
        Route::put('/certificadoC/activar', 'CertificadoCertificaController@activar');
        Route::get('/certificadoC/certificadoPdf/{id}', 'CertificadoCertificaController@certificadoPdf');
        Route::get('/certificado/certificadoPdfEmisionSinFondo/{id}', 'CertificadoController@certificadoPdfEmisionSinFondo'); 
        Route::get('/codigoqr', 'CertificadoController@codigoqr'); 
        Route::post('/certificado/edicion', 'CertificadoController@edicion');
        Route::post('/certificadoC/edicion', 'CertificadoController@edicion');
        Route::get('/edicioncerti2', 'CertificadoCertificaController@edicioncerti2');//KPS
        Route::post('/edicion/desaprobar', 'CertificadoController@desaprobar');
        Route::post('/edicion/aprobar', 'CertificadoController@aprobar');
        //Gestion de Carne
        Route::put('/carneC/actualizar', 'CertificadoCertificaController@actualizarCarne');
        Route::put('/carneC/emitir', 'CertificadoCertificaController@emitirCarne');
        Route::put('/carneC/emitir1', 'CertificadoCertificaController@emitirCarne1');
        Route::post('/carneC/revalidacion', 'CarneCertificaController@store');
        Route::get('/carneC/carnePdf/{id}', 'CarneCertificaController@carnePdf'); 
        Route::get('/carneC/carnePdfEmision/{id}', 'CarneCertificaController@carneEmisionPdf'); 
        Route::get('/carneC/carnePdfEmision1/{id}', 'CarneCertificaController@carneEmisionPdf1'); 
        //Generar Carne
        Route::put('/emitir/Carne', 'CarneController@emiCard'); 
        Route::put('/carne/update', 'CarneController@actualizarCarne'); 
        //Gestión de Firma
        Route::get('/firmaC', 'FirmaCertificaController@index');
        Route::post('/firmaC/registrar', 'FirmaCertificaController@store');
        Route::post('/firmaC/actualizar', 'FirmaCertificaController@update');
        Route::put('/firmaC/desactivar', 'FirmaCertificaController@desactivar');
        Route::put('/firmaC/activar', 'FirmaCertificaController@activar');
        Route::get('/firmaC/selectFirma', 'FirmaCertificaController@selectFirma');  
        //FIN ISO 17024

    });

    Route::group(['middleware'=>['CICB']],function(){
        //Gestión de Lote
        Route::get('/lote', 'LoteController@index');
        Route::post('/lote/registrar', 'LoteController@store');
        Route::put('/lote/actualizar', 'LoteController@update');
        Route::put('/lote/desactivar', 'LoteController@desactivar');
        Route::put('/lote/activar', 'LoteController@activar');
        Route::get('/lote/selectLote', 'LoteController@selectLote');
    });
    
   
    });





