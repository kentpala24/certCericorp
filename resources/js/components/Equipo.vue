<template>
         <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item"><a href="#">Admin</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Certificados Equipos
                        <button type="button" @click="Verdetalle('equipo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo Certificado
                        </button>
                    </div>
                    
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">Empresa: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bempresa" @keyup.enter="listarEquipo(1,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)" class="form-control" placeholder="Company" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Nº Certificado: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bnumero" @keyup.enter="listarEquipo(1,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)" class="form-control" placeholder="Nº Certificate"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Tipo Equipo: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bequipo" @keyup.enter="listarEquipo(1,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)" class="form-control" placeholder="Tipo de Equipo"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Modelo: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bmodelo" @keyup.enter="listarEquipo(1,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)" class="form-control" placeholder="Modelo"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Nº Serie: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bserie" @keyup.enter="listarEquipo(1,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)" class="form-control" placeholder="Serie"></div>
                                    <label class="col-md-4 form-control-label" for="solicitante">Estado Certificado: </label> 
                            <div class="col-md-5">
                                        <select class="form-control" v-model="bvigencia">
                                            <option value="0">TODOS</option>
                                            <option value="1">VIGENTES</option>
                                            <option value="2">VENCIDOS</option>
                                        </select>
                                    
                                </div>

                            <button type="submit" @click="listarEquipo(1,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div> 
                            
                                </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Certificado</th>
                                    <th>Certi. Sin Fondo</th>
                                    <th>Nº Certificado</th>
                                    <th>Empresa</th>
                                    <th>Tipo de Equipo</th>
                                    <th>Marca/Modelo</th>
                                    <th>Nº Serie</th>
                                    <th>Fecha Emision</th>
                                    <th>Fecha Expiracion</th>
                                    <th>Estado </th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr v-for="equipos in arrayEquipo" :key="equipos.id">
                                    <td>
                                        <template v-if="equipos.estado==0">
                                            <button type="button" class="btn btn-info btn-sm" @click="activarEquipo(equipos.id)">
                                            <i class="icon-check"></i>
                                            </button> 
                                        </template> 
                                        <template v-if="equipos.estado==1">
                                            <button type="button" @click="Verdetalle('equipo','actualizar',equipos)" class="btn btn-info btn-sm" >
                                            <i class="icon-pencil"></i>
                                            </button> 
                                            
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEquipo(equipos.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>  
                                        <template v-if="equipos.estado==2">
                                            <button type="button" @click="Verdetalle('equipo','actualizar',equipos)" class="btn btn-info btn-sm" >
                                            <i class="icon-pencil"></i>
                                            </button> 

                                            <button type="button" @click="cargarPdfemision(equipos.id)" class="btn btn-info btn-sm" >
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                            </svg>
                                            </button> 
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarEquipo(equipos.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>                                          
                                    </td>
                                    <td>
                                         
                                        <template v-if="equipos.estado==2">
                                            
                                            <button type="button" @click="cargarPdfemisionSinFondo(equipos.id)" class="btn btn-warning btn-sm" >
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                            </svg>
                                            </button> 
                                        </template>                                          
                                    </td>
                                    <td v-text="equipos.certificado"></td>
                                    <td v-text="equipos.cliente"></td>
                                    <td v-text="equipos.tipo_equipo"></td>
                                    <td v-text="equipos.marca+' '+equipos.modelo"></td>
                                    <td v-text="equipos.serie"></td>
                                    <td v-html="equipos.fecha_emision"></td>
                                    <td v-text="equipos.fecha_expiracion"></td>
                                    
                                    <td><div v-if="equipos.estado==0">
                                        <span class="badge badge-secondary">Cancelado</span>
                                        </div> 
                                        <div v-else-if="equipos.estado==1">
                                        <span class="badge badge-warning">En Proceso</span>
                                        </div>
                                        <div v-else-if="equipos.fecha_expiracion<fechahoy()">
                                        <span class="badge badge-danger">Vencido</span>
                                        </div>
                                        <div v-else-if="equipos.estado==2">
                                        <span class="badge badge-secondary">Emitido</span>
                                        </div>
                                        

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <template v-else-if="listado==0">
                <form @submit.prevent="formData" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <!-- Mostrar Datos -->
                    <div class="card-body">
                        <div class="form-group row border">
                            <h2 v-text="tituloModal"></h2>
                        </div>
                        <div class="form-group row border">
                            
                            <div class="col-md-12">
                                <h5>1. INFORMACIÓN GENERAL</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 form-control-label" for="text-input">Cliente</label>
                                    <div class="col-md-12">
                                        <v-select
                                            :options="arrayClienteR"
                                            label="cliente"
                                            :reduce="cliente => cliente.id"
                                            v-model="idClienteN"
                                            placeholder="Seleccionar Cliente"
                                        ></v-select>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">LUGAR: </label>
                                    <input type="text" v-model="lugar" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                    <label for="">F. Emision: </label>
                                    <input type="date" v-model="fecha_Emision" class="form-control">
                                </div>   
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                    <label for="">Ultimo F. Inspección: </label>
                                    <input type="date" v-model="fecha_inspeccion" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                    <label for="">F. Inspección Cert.: </label>
                                    <input type="text" v-model="fecha_certificado" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">F. Vencimiento: </label>
                                    <input type="date" v-model="fecha_vencimiento" class="form-control">
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <h5>2. IDENTIFICACIÓN DEL EQUIPO</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 form-control-label" for="text-input">Equipo</label>
                                    <div class="col-md-12">
                                        <v-select
                                            :options="arrayEquipoR"
                                            label="equipo"
                                            :reduce="equipo => equipo.id"
                                            v-model="idEquipoN"
                                            placeholder="Seleccionar Equipo"
                                        ></v-select>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Propietario: </label>
                                    <input type="text" v-model="propietario" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                    <label for="">Campo 1: </label>
                                    <input type="text" v-model="campo1" class="form-control">
                                </div>   
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                    <label for="">Respuesta 1: </label>
                                    <input type="text" v-model="respuesta1" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-3"> 
                                <div class="form-group">
                                    <label for="">Campo 2: </label>
                                    <input type="text" v-model="campo2" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="">Respuesta 2: </label>
                                    <input type="text" v-model="respuesta2" class="form-control">
                                </div> 
                            </div>
                            <div class="col-md-12">
                                <h5>3. ALCANCE DE INSPECCIÓN:</h5>
                                <h6>Para separar los alcances separarlos con ",":</h6>
                            </div>
                            <div class="col-md-12">
                                <textarea v-model="normativa" cols="30" rows="4"  class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <h5>4. PARÁMETROS DE PRUEBA DE CARGA:</h5>
                                <h6>Para que no se muestre un campo completarlo con "-":</h6>
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label for="">PARAMETRO NOMINALES DE OPERACIÓN: </label>
                                    <input type="text" v-model="capacidad_nominal" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label for="">PARAMETRO DE PRUEBA: </label>
                                    <input type="text" v-model="peso_certi" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Tasa de Prueba de Carga: </label>
                                    <input type="text" v-model="tasa_prueba" class="form-control">
                                </div> 
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label for="">Longitud Pluma: </label>
                                    <input type="text" v-model="longitud_pluma" class="form-control">
                                </div>   
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label for="">Angulo de Pluma: </label>
                                    <input type="text" v-model="angulo_pluma" class="form-control">
                                </div>   
                            </div>
                            <div class="col-md-4"> 
                                <div class="form-group">
                                    <label for="">Radio Operativo: </label>
                                    <input type="text" v-model="radio_operativo" class="form-control">
                                </div>   
                            </div>
                            <div class="col-md-12">
                                <h5>5. CONCLUSIONES / VALIDEZ / FIRMAS:</h5>
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="">Informe: </label>
                                    <input type="text" v-model="informe" class="form-control">
                                    </div>
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="">Vigencia Texto: </label>
                                    <input type="text" v-model="vigenciaTexto" class="form-control">
                                    </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Firma:</label>
                                    <select class="form-control" v-model="firma_id">
                                            <option value="0">Seleccionar Firma</option>
                                            <option v-for="firma in arrayFirma" :key="firma.id" :value="firma.id" v-text="firma.nombre"></option>
                                        </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Firma 2:</label>
                                    <select class="form-control" v-model="firma_id2">
                                            <option value="0">Seleccionar Firma</option>
                                            <option v-for="firma in arrayFirma" :key="firma.id" :value="firma.id" v-text="firma.nombre"></option>
                                        </select>
                                </div> 
                            </div>
                            <div class="col-md-3">
                                    <div class="form-group">
                                    <label for="">Separador de Firma(s): </label>
                                    <input type="text" v-model="separador" class="form-control">
                                    </div>
                            </div>
                            <div class="col-md-4">
                                    <label class="col-md-12 form-control-label" for="text-input">Certificado PDF</label>
                                    <div class="col-md-12">
                                        <input type="file" @change="obtenerImagen" name="perfil" class="form-control" placeholder="Cargar Certificado">
                                    </div>
                                    <label class="col-md-12 form-control-label" for="text-input"></label>
                            </div>
                            <div class="col-md-3" v-if="ubicacion">
                                <div class="form-group">
                                    <label for="">Ver Certificado Físico</label>
                                    <div class="col-md-9">
                                        <button><a :href="'/storage/'+ubicacion"  target="_blank">Clic Aquí</a></button>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    <div class="form-group row">
                     <button type="button" class="btn btn-danger" @click="MirarResumen()">Cancel</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==2 && estadoCE==1" class="btn btn-primary" @click="cargarPdfedicion(idequipo)">Vista Previa</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==2 && estadoCE==2" class="btn btn-primary" @click="cargarPdfemision(idequipo)">Ver Certificado</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==2 && estadoCE==1" class="btn btn-primary" @click="generateCerti()">Emitir Certificado</button>&nbsp;&nbsp;
                     <button v-if="tipoAccion==1" class="btn btn-primary">Guardar</button>
                     <button v-if="tipoAccion==2" class="btn btn-primary">Actualizar</button> 
                        </div>             
                    </div>
                </form>
                        </template>
            </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            
            
        </main>
</template>


<script>

import moment from 'moment';

import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
import vSelect from 'vue-select'
export default { 
    name: 'app',
    components: { vSelect },
        data(){
            return{
                //editor de texto
                editor: ClassicEditor,
                editorData: '<p>Content of the editor.</p>',
                editorConfig: {
                    },
                //Equipo
                idequipo:'',
                codigo_certificado:'',
                codigo_informe:'',
                fechaIspeccion:'',
                fechaRecomendada:'',
                fechaEmision:'',
                tipoEquipo:'',
                marca:'',
                modeloEquipo:'',
                serie:'',
                capacidad:'',
                ruc:'',
                cliente:'',
                pdsi:'',
                otro:'',
                normativa:'',

                //buscar
                bpdsi:'',
                bempresa:'',
                bnumero:'',
                bequipo:'',
                bmodelo:'',
                bserie:'',
                bvigencia:0,

                //
                arrayEquipo: [],
                arrayClienteR:[],
                arrayEquipoR:[],
                fecha_Emision:'',
                fecha_inspeccion:'',
                fecha_certificado:'',
                fecha_vencimiento:'',
                lugar:'',
                idEquipoN:0,
                campo1:'',
                respuesta1:'',
                campo2:'',
                respuesta2:'',
                capacidad_nominal:'',
                peso_certi:'',
                tasa_prueba:'',
                longitud_pluma:'',
                angulo_pluma:'',
                radio_operativo:'',
                vigenciaTexto:'',
                informe:'',
                arrayFirma:[],
                firma_id:'',
                idClienteN:0,
                estadoCE:'',
                separador:'',
                imagen:'',
                imagenMiniatura:'',
                ubicacion:'',
                //
                
                modal : 0,
                tituloModal:'',
                tipoAccion : 0 ,
                listado: 1,
                errorRevision : 0,
                errorMostrarMsjRevision : [],
                pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
                },
                offset : 3,
                criterio : 'revalidacion',
                buscar :''
            }

        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //calcula los elementos de la paginacion 
            pagesNumber: function(){
                    if(!this.pagination.to){
                        return [];
                    }
                    var from = this.pagination.current_page - this.offset;
                    if(from < 1) {
                        from = 1;
                    }
                    var to = from + (this.offset * 2);
                    if(to >= this.pagination.last_page) {
                        to = this.pagination.last_page;
                    }
                    var pagesArray =[];
                    while(from <=  to){
                        pagesArray.push(from);
                        from++;
                    }
                    return pagesArray;
            }
        },
        methods : {
            listarEquipo(page,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia){
                this.selectCliente();
                this.selectEquipos();
                this.selectFirma();
                let me=this;
                var url= '/equipo?page=' + page + '&bpdsi='+ bpdsi+ '&bempresa='+ bempresa
                + '&bnumero='+ bnumero+ '&bequipo='+ bequipo + '&bmodelo='+ bmodelo+ '&bserie='+ bserie+ '&bvigencia='+ bvigencia;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEquipo = respuesta.equipos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            obtenerImagen(e){
                this.imagen = e.target.files[0];
                console.log(this.imagen);
                var reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }
            },
            selectCliente(){
                let me=this;
                var url='/clientes/selectCliente';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayClienteR = respuesta.clientes;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectEquipos(){
                let me=this;
                var url='/datoEquipo/selectEquipos';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayEquipoR = respuesta.equipos;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectFirma(){
                let me=this;
                var url='/firma/selectFirmaBo';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayFirma = respuesta.firmas;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            formData(){
                let me=this;
                let indi=1;
                const formData = new FormData;
                formData.set('id', this.idequipo)
                formData.set('lugar', this.lugar)
                formData.set('fecha_Emision', this.fecha_Emision)
                formData.set('fecha_inspeccion', this.fecha_inspeccion)
                formData.set('fecha_certificado', this.fecha_certificado)
                formData.set('fecha_vencimiento', this.fecha_vencimiento)
                formData.set('idClienteN', this.idClienteN)
                formData.set('idEquipoN',this.idEquipoN)
                formData.set('campo1', this.campo1)
                formData.set('respuesta1', this.respuesta1)
                formData.set('campo2', this.campo2)
                formData.set('respuesta2', this.respuesta2)
                formData.set('capacidad_nominal',this.capacidad_nominal)
                formData.set('peso_certi',this.peso_certi)
                formData.set('tasa_prueba',this.tasa_prueba)
                formData.set('longitud_pluma',this.longitud_pluma)     
                formData.set('angulo_pluma',this.angulo_pluma)
                formData.set('radio_operativo',this.radio_operativo)
                formData.set('vigenciaTexto',this.vigenciaTexto)
                formData.set('informe',this.informe)
                formData.set('normativa',this.normativa) 
                formData.set('propietario',this.propietario) 
                formData.set('firma_id',this.firma_id)
                formData.set('firma_id2',this.firma_id2)  
                formData.set('separador',this.separador)      
                formData.set('archivo',this.imagen)
                if(this.idequipo==''){
                    axios.post('/equipo/registrar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarEquipo(1,'','','','','','','');
                    indi=1;
                })
                .catch(function (error){
                    console.log(error);
                    indi=0;
                });
                }
                else{
                    axios.post('/equipo/actualizar',formData).then(function (response){
                    me.ubicacion=response.data.ruta_certi_fisi;
                    console.log(me.ubicacion);
                    //me.cerrarModal();
                    me.listarEquipo(1,'','','','','','','');
                    //me.listado=1;
                })
                .catch(function (error){
                    console.log(error);
                });
                }
                
            },
            GuardarEquipo(){
                let me = this;
                    axios.put('/equipo/registrar',
                    {   'lugar': this.lugar,
                        'fecha_Emision': this.fecha_Emision,
                        'fecha_inspeccion': this.fecha_inspeccion,
                        'fecha_certificado': this.fecha_certificado,
                        'fecha_vencimiento': this.fecha_vencimiento,
                        'idClienteN': this.idClienteN,
                        'idEquipoN':this.idEquipoN,
                        'campo1': this.campo1,
                        'respuesta1': this.respuesta1,
                        'campo2': this.campo2,
                        'respuesta2': this.respuesta2,
                        'capacidad_nominal':this.capacidad_nominal,
                        'peso_certi':this.peso_certi,
                        'tasa_prueba':this.tasa_prueba,
                        'longitud_pluma':this.longitud_pluma,     
                        'angulo_pluma':this.angulo_pluma,
                        'radio_operativo':this.radio_operativo,
                        'vigenciaTexto':this.vigenciaTexto,   
                        'informe':this.informe,    
                        'normativa':this.normativa, 
                        'propietario':this.propietario, 
                        'firma_id':this.firma_id,    
                        'firma_id2':this.firma_id2,  
                        'separador':this.separador,      
                        'archivo':this.imagen,       
                    }).then(function (response) {
                        me.listarEquipo(1,'','','','','','','');
                        me.listado=1;
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            ActualizarEquipo(){
                let me = this;
                    axios.post('/equipo/actualizar',
                    {
                        'id': this.idequipo,
                        'lugar': this.lugar,
                        'fecha_Emision': this.fecha_Emision,
                        'fecha_inspeccion': this.fecha_inspeccion,
                        'fecha_certificado': this.fecha_certificado,
                        'fechaRecomendada': this.fechaRecomendada,
                        'fecha_vencimiento': this.fecha_vencimiento,
                        'idClienteN': this.idClienteN,
                        'idEquipoN':this.idEquipoN,
                        'campo1': this.campo1,
                        'respuesta1': this.respuesta1,
                        'campo2': this.campo2,
                        'respuesta2': this.respuesta2,
                        'capacidad_nominal':this.capacidad_nominal,
                        'peso_certi':this.peso_certi,
                        'tasa_prueba':this.tasa_prueba,
                        'longitud_pluma':this.longitud_pluma,     
                        'angulo_pluma':this.angulo_pluma,
                        'radio_operativo':this.radio_operativo,
                        'vigenciaTexto':this.vigenciaTexto,   
                        'informe':this.informe,    
                        'normativa':this.normativa,
                        'propietario':this.propietario, 
                        'firma_id':this.firma_id,    
                        'firma_id2':this.firma_id2, 
                        'separador':this.separador,  
                        'archivo':this.imagen,                      
                    }).then(function (response) {
                        me.listarEquipo(1,'','','','','','','');
                       // me.listado=1;
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                
            },
            generateCerti(){
                let me = this;
                    axios.put('/equipo/generateCerti',
                    {
                        'id': this.idequipo,
                        
                    }).then(function (response) {
                        me.listarEquipo(1,'','','','','','','');
                        var respuesta= response.data;
                        if(response.statusText=="OK"){
                            me.listado=1;
                        }
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                me.listado=1;
            },
            cargarPdfemision(id){
                window.open('/equipo/certificadoPdfEmision/'+id,'_blanck')
            },
            cargarPdfemisionSinFondo(id){
                window.open('/equipo/certificadoPdfEmisionSF/'+id,'_blanck')
            },
            cargarPdfedicion(id){
                window.open('/equipo/certificadoPdf/'+id,'_blanck')
            },
            cerrarModal(){
                    this.modal = 0;
                    this.tituloModal = '';
                    this.idusuario= '';
            },
            fecha(d){
                return moment(d).format("YYYY-MM-DD");
            },
            fechahoy(){
                return moment().format("YYYY-MM-DD");
            },

            MirarResumen(){
                this.listado=1;
                this.idequipo='';
                this.codigo_certificado='';
                this.codigo_informe='';
                this.fechaIspeccion='';
                this.fechaRecomendada='';
                this.fechaEmision='';
                this.tipoEquipo='';
                this.marca='';
                this.modeloEquipo='';
                this.serie='';
                this.capacidad='';
                this.ruc='';
                this.cliente='';
                this.pdsi='';
                this.otro='';
            },
            fecha (d){
                return moment(d).format("YYYY-MM-DD");
            },
            cambiarPagina(page,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para visualizar la data de esa pagina 
                me.listarEquipo(page,bpdsi,bempresa,bnumero,bequipo,bmodelo,bserie,bvigencia);
            },
                        
            validarRevision(){
                    this.errorRevision=0;
                    this.errorMostrarMsjRevision =[];

                    if(!this.idusuario) this.errorMostrarMsjRevision.push("It cant be empty.");
                    if(this.errorMostrarMsjRevision.length) this.errorRevision = 1;
                    return this.errorRevision;
           
            },
            desactivarEquipo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to deactivate this Equipment?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/equipo/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarEquipo(1,'','','','','','','');
                     swalWithBootstrapButtons.fire(
                    'Disabled',
                    'Registration has been successfully deactivated.',
                    'success'
                    )
                })
                .catch(function (error){
                    console.log(error);
                });
                   
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            activarEquipo(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to activate this Equipment?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/equipo/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarEquipo(1,'','','','','','','');
                     swalWithBootstrapButtons.fire(
                    'Activated',
                    'Registration has been activated successfully.',
                    'success'
                    )
                })
                .catch(function (error){
                    console.log(error);
                });
                   
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    
                }
                })
            },
            Verdetalle(modelo, accion, data = []){
                this.listado=0;
                switch(modelo){
                    case "equipo":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.tituloModal = 'Generar Certificado de Equipos';
                                    this.tipoAccion= 1;
                                    this.idequipo='';
                                    this.lugar='';
                                    this.fecha_Emision='';
                                    this.fecha_inspeccion='';
                                    this.fecha_certificado='';
                                    this.fechaRecomendada='';
                                    this.fecha_vencimiento='';
                                    this.idClienteN='';
                                    this.campo1='';
                                    this.respuesta1='';
                                    this.campo2='';
                                    this.propietario='';
                                    this.respuesta2='';
                                    this.capacidad_nominal='';
                                    this.peso_certi='';
                                    this.tasa_prueba='';
                                    this.longitud_pluma='';     
                                    this.angulo_pluma='';
                                    this.radio_operativo='';
                                    this.vigenciaTexto='';   
                                    this.informe='';    
                                    this.firma_id='';    
                                    this.firma_id2='';  
                                    this.idEquipoN='';
                                    this.normativa='';
                                    this.estadoCE='';
                                    this.separador='';
                                    this.ubicacion='';
                                    break;
                                }
                                case 'actualizar':
                                {
                                    this.tituloModal = 'Vista Preliminar';
                                    this.tipoAccion=2;
                                    this.idequipo=data['id'];
                                    this.lugar=data['lugar'];
                                    this.fecha_Emision=data['fecha_emision'];
                                    this.fecha_inspeccion=data['fecha_inspeccion'];
                                    this.fecha_certificado=data['fecha_inspeccion2'];
                                    this.fecha_vencimiento=data['fecha_expiracion'];
                                    this.idClienteN=data['id_cliente'];
                                    this.campo1=data['campo1'];
                                    this.respuesta1=data['resultado1'];
                                    this.campo2=data['campo2'];
                                    this.respuesta2=data['resultado2'];
                                    this.capacidad_nominal=data['capa_maxima'];
                                    this.peso_certi=data['peso_certificacion'];
                                    this.tasa_prueba=data['tasa_prueba'];
                                    this.longitud_pluma=data['longitud_pluma'];  
                                    this.angulo_pluma=data['angulo_pluma'];
                                    this.radio_operativo=data['radio_opera'];
                                    this.vigenciaTexto=data['vigencia'];   
                                    this.informe=data['informe']; 
                                    this.firma_id=data['id_firma']; 
                                    this.firma_id2=data['id_firma2'];
                                    this.normativa=data['normativa'];
                                    this.idEquipoN=data['id_dato_equipo'];
                                    this.propietario=data['propietario'];
                                    this.estadoCE=data['estado'];
                                    this.separador=data['separador'];
                                    this.ubicacion=data['ruta_certi_fisi'];                               
                                    break;
                                }
                            }
                        }
                }
            }
        },
        mounted() {
           this.listarEquipo(1,this.bpdsi,this.bempresa,this.bnumero,this.bequipo,this.bmodelo,this.bserie,this.bvigencia);
        }
    }
</script>
<style>
@import '~vue-select/dist/vue-select.css';
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }

</style>