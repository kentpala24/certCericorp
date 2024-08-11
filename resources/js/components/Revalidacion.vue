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
                        <i class="fa fa-align-justify"></i> DIGITAL CARD  
                        <button type="button" @click="Verdetalle('revalidacion','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Generate Card
                        </button>
                    </div>
                    
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">PDSI: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bpdsi" @keyup.enter="listarRevalidacion(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="PDSI" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">Company: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bempresa" @keyup.enter="listarRevalidacion(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Company" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Nº Certificate: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bnumero" @keyup.enter="listarRevalidacion(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Nº Certificate"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Professional Name: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bnpersona" @keyup.enter="listarRevalidacion(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Name Professional"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Professional Surname: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bapersona" @keyup.enter="listarRevalidacion(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Surname Professional"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Certificate type: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="btipo_certificado" @keyup.enter="listarRevalidacion(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Certificate type"></div>
                                    <button type="submit" @click="listarRevalidacion(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div> 
                                </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Cards</th>
                                    <th>PDSI / Batch Nº</th>
                                    <th>Nº Certificate</th>
                                    <th>Professional</th>
                                    <th>Certificate type </th>
                                    <th>Equipment(s)</th>
                                    <th>Level</th>
                                    <th>Date</th>
                                    <th>Expiration date</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr v-for="revalidaciones in arrayRevalidacion" :key="revalidaciones.id">
                                        <td>
                                        <template v-if="revalidaciones.estado==0">
                                            <button type="button" @click="Verdetalle('revalidacion','ver',revalidaciones)" class="btn btn-info btn-sm" >
                                            <i class="icon-eye"></i>
                                            </button> 
                                        </template> 
                                        <template v-if="revalidaciones.estado==1">
                                            <button type="button" @click="Verdetalle('revalidacion','editar',revalidaciones)" class="btn btn-info btn-sm" >
                                            <i class="icon-pencil"></i>
                                            </button> 
                                            <button type="button" class="btn btn-success btn-sm" @click="cargarCarnePdfemision1(revalidaciones.id)">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-heading" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                                    <path fill-rule="evenodd" d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                                                    <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z"/>
                                                </svg>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarRevalidacion(revalidaciones.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>   
                                        <template v-if="revalidaciones.estado==2">
                                            <button type="button" class="btn btn-info btn-sm" @click="activarRevalidacion(revalidaciones.id)">
                                            <i class="icon-check"></i>
                                            </button>  
                                        </template>                                          
                                    </td>
                                    <td v-html="revalidaciones.pdsi"></td>
                                    <div v-if="revalidaciones.numero==0">
                                        <td>Without Issuing</td>
                                    </div>
                                    <div v-else>
                                        <td v-text="'P - '+revalidaciones.numero"></td>
                                    </div>
                                    <td v-text="revalidaciones.persona"></td>
                                    <td v-text="revalidaciones.designacion"></td>
                                    <td v-html="revalidaciones.equipo"></td>
                                    <td v-text="revalidaciones.nivel"></td>
                                    <td v-text="revalidaciones.fecha_reevaluacion"></td>
                                    <td v-text="revalidaciones.fecha_vence"></td>
                                    <td> <div v-if="revalidaciones.estado==1">
                                        <span class="badge badge-secondary">Issued</span>
                                        </div>
                                        <div v-else-if="revalidaciones.fecha_vence<fechahoy()">
                                        <span class="badge badge-danger">Expired</span>
                                        </div>
                                        <div v-else-if="revalidaciones.estado==0">
                                        <span class="badge badge-secondary">In Issue</span>
                                        </div>
                                        <div v-else-if="revalidaciones.estado==2">
                                        <span class="badge badge-secondary">Canceled</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <template v-else-if="listado==0">
                    
                            <!-- Mostrar Datos -->
                    <div class="card-body">
                        <div class="form-group row border">
                            <h2 v-text="tituloModal"></h2>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">PDSI:</label>
                                    <input type="text" v-model="pdsi" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for=""># Certificate: P-</label>
                                    <input type="text" v-model="numero" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Professional <span style="color:red;" v-show="idpersona==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="dni" @keyup.enter="buscarPersona()" placeholder="Enter personnel ID ">
                                        <button @click="buscarPersona()" class="btn btn-primary">...</button>
                                        <input type="hidden" v-model="idpersona" class="form-control">
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Professional:</label>
                                    <select class="form-control" v-model="idpersona">
                                            <option value="0">Select a Professional</option>
                                            <option v-for="personas in arrayPersona1" :key="personas.id" :value="personas.id" v-text="personas.nombre+' '+personas.apellido"></option>
                                        </select>
                                </div>  
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <label>Company:</label>
                                    <input type="text" v-model="empresa" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Certificate type :</label>
                                    <select class="form-control" v-model="tipo_certificado_id">
                                            <option value="0">Select a</option>
                                            <option v-for="tipo in arrayTipo_certificado" v-bind:key="tipo.id" :value="tipo.id" v-text="tipo.nombre"></option>
                                    </select>
                                <template v-if="tipo_certificado_id==5">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionOperador" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>
                                <template v-if="tipo_certificado_id==6">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionRigger" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>

                                <template v-if="tipo_certificado_id==7">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionSupervisor" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>

                                <template v-if="tipo_certificado_id==8">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionInspector" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>
                                    

                                    
                                </div>  
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Equipment:</label>
                                    
                                    <select class="form-control" v-model="cond_equipo">
                                            <option value="0">Do not include equipment</option>
                                            <option value="1">Include Equipment</option>
                                            <option value="2">Include Truck, Yellow Line, White Line</option>
                                    </select>
                                    <template v-if="cond_equipo==1">
                                        ES: <textarea v-model="equipo" cols="80" rows="5" class="form-control"></textarea>
                                    </template>
                                    <template v-if="cond_equipo==2">
                                        ES: <textarea v-model="equipo" cols="75" rows="2" class="form-control"></textarea>
                                    </template>
                                    </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Level:</label>
                                    <select class="form-control" v-model="nivel">
                                        <option value="Basic Level">Basic Level</option>
                                        <option value="Intermediate Level">Intermediate Level</option>
                                        <option value="Level 1">Level 1</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Normative Spanish:<button @click="buscarDesignacion()" class="btn btn-primary">...</button></label>
                                    <input type="text" v-model="normativaes" class="form-control">
                                </div> 
                            </div>
                             <div class="col-md-5">
                                <div class="form-group">
                                    <div class="form-inline">
                                    <select class="form-control" v-model="revalidacion">
                                        <label>Select evaluation days</label>
                                            <option value="0">Emisión</option>
                                            <option value="1">Revalidacion</option>
                                    </select><br/>                  
                                    </div>
                                    <template v-if="revalidacion==1"> 
                                        <div class="form-inline">
                                                <label>Revalidación:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="date" v-model="fecha_reevaluacion" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Expiress:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_vence" class="form-control">
                                        </div>
                                    </template>
                                    <template v-if="revalidacion==0"> 
                                        <template v-if="nivel=='Intermediate Level'">
                                        <div class="form-inline">
                                                <label>Emisión:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="date" v-model="fecha_emision" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Revalidación:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_reevaluacion" class="form-control">
                                        </div>
                                        </template>
                                        <template v-if="nivel=='Basic Level'">
                                        <div class="form-inline">
                                                <label>Emisión:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                                <input type="date" v-model="fecha_emision" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Expiress:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_vence" class="form-control">
                                        </div>
                                        </template>
                                    </template>
                                        
                                </div> 
                            </div>
                        </div>
                    <div class="form-group row">
                     <button type="button" class="btn btn-danger" @click="MirarResumen()">Cancel</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarCarnePdfedicion(idrevalidacion)">Preview</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==1 || tipoAccion==3" class="btn btn-primary" @click="ActualizarCarne()">To update</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==1 || tipoAccion==3" class="btn btn-warning" @click="vistaPrevia()">Advanced Edition</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="EmitirCarne()">Issue Card</button>
                     <button type="button" v-if="tipoAccion==2" class="btn btn-info" @click="GenerateCarne()">Initiate Card Issuance</button>
                        </div>             
                    </div>
                        </template>
                <template v-else-if="listado==2">
                    <!-- Datos de Carné -->
                    
                    <div class="card-body">
                        
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <textarea v-model="nombrescarne" cols="80" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label v-html="nombrescarne"></label>
                            </div>

                            <div class="col-md-6">
                                <textarea v-model="empresacarne" cols="80" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label v-html="empresacarne"></label>
                            </div>

                            <div class="col-md-6">
                                <textarea v-model="designacioncarne" cols="80" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label v-html="designacioncarne"></label>
                            </div>
                    </div>
                    <div class="form-group row border">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong><label v-text="'Nota:'"></label></strong><br/>
                                    <label v-text="'<br/> : Genera un Salto de línea'"></label><br/>
                                    <label v-text="'&nbsp; : Genera un espacio en blanco'"></label><br/>
                                    <label v-text="'<b></b>: Pone en negrita todo el texto dentro de la etiqueta'"></label><br/>
                                    <label v-text="'<h1></h1>: Los h1, h2, h3, h4, h5 y h6 son encabezados donde el más grande es h1 y el más pequeño es h6.'"></label><br/> 

                                        
                                </div>  
                            </div>
                        </div>
                          
                        <div class="form-group row">
                            <button type="button" v-if="tipoAccion==1 || tipoAccion==3" class="btn btn-danger" @click="MirarResumen()">Return</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==1" class="btn btn-info" @click="cargarCarnePdfedicion(idrevalidacion)">Preview</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==1 || tipoAccion==3" class="btn btn-warning" @click="actualizarCarneA()">To update</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="EmitirCarne()">Issue Card</button>
                        </div>             
                    </div>
            </template>
            </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            
            
        </main>
</template>


<script>

import moment from 'moment';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
    name: 'app',
        data(){
            return{
                //editor de texto
                editor: ClassicEditor,
                editorData: '<p>Content of the editor.</p>',
                editorConfig: {
                    },

                //Datos de Table
                idusuario:0,
                idrevalidacion: 0,
                iddesignacion:0,
                idpersona:0,
                tipo_certificado_id:0,
                numero:0,
                persona:'',
                pdsi:0,
                empresa:'',
                designacion:'',
                equipo:'',
                cond_equipo:'',
                nivel:'',
                revalidacion:'',
                revalidaciones:'',
                fecha_emision: '',
                fecha_reevaluacion: '',
                fecha_vence: 1,
                normativa_espanol: '',
                nombrescarne: '',
                empresacarne:'',
                designacioncarne:'',
                estado:'',
                dni:'',
                nombre:'',
                apellido:'',
                
                //Designacion
                designation:'',
                designacioncert:'',
                designacion_espanol:'',
                normativaes:'',
                equipoes:'',
                //buscar
                bpdsi:'',
                bempresa:'',
                bnumero:'',
                bnpersona:'',
                bapersona:'',
                btipo_certificado:'',
                //
                arrayRevalidacion: [],
                arrayDesignacion: [],
                arrayTipo_certificado: [],
                arrayDesignacionOperador: [],
                arrayDesignacionRigger: [],
                arrayDesignacionSupervisor: [],
                arrayDesignacionInspector: [],
                arrayDesignacion: [],
                arrayPersona: [],
                arrayPersona1: [],
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
            listarRevalidacion(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado){
                let me=this;
                var url= '/revalidacion?page=' + page + '&bpdsi='+ bpdsi+ '&bempresa='+ bempresa
                + '&bnumero='+ bnumero+ '&bnpersona='+ bnpersona + '&bapersona='+ bapersona+ '&btipo_certificado='+ btipo_certificado;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRevalidacion = respuesta.revalidaciones.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            CarneGenerate(){

            },
            cargarPdf(){
                window.open('/certificado/certificadoPdf','_blanck');
            },
            cargarCarnePdfedicion(id){
                window.open('/revalidacion/carnePdf/'+id,'_blanck')
            },
            cargarPdfemision(id){
                window.open('/certificado/certificadoPdfEmision/'+id,'_blanck')
            },
            cargarCarnePdfemision1(id){
                window.open('/revalidacion/carnePdfEmision1/'+id,'_blanck')
            },
            selectLote(){
                let me=this;
                var url='/lote/selectLote';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayLote = respuesta.lotes;
                    
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectFirma(){
                let me=this;
                var url='/firma/selectFirma';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayFirma = respuesta.firmas;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectPersona(){
                let me=this;
                var url='/persona/selectPersona';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayPersona1 = respuesta.personas;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectTipo_Certificado(){
                let me=this;
                var url='/tipo/selectTipo_Certificado';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayTipo_certificado = respuesta.tipos;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectDesignacionOperador(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=5';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionOperador = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectDesignacionRigger(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=6';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionRigger = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectDesignacionSupervisor(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=7';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionSupervisor = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectDesignacionInspector(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=8';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionInspector = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            EmitirCarne(){
                let me = this;
                    axios.put('/revalidacion/emitircarne',
                    {
                        'id':this.idrevalidacion,                       
                    }).then(function (response) {
                        me.listarRevalidacion(1,'','','','','','');
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                this.listado=1;
            },
            GenerateCarne(){
                let me = this;
                    axios.put('/revalidacion/carne',
                    {
                        'iddesignacion': this.iddesignacion,
                        'idpersona': this.idpersona,
                        'numero': this.numero,
                        'persona': this.persona,
                        'pdsi': this.pdsi,
                        'empresa': this.empresa,
                        'designacion': this.designacion,
                        'equipo': this.equipo,
                        'cond_equipo': this.cond_equipo,
                        'nivel': this.nivel,
                        'foto': this.foto,
                        'revalidacion':this.revalidacion,
                        'fecha_emision':this.fecha_emision,
                        'fecha_reevaluacion':this.fecha_reevaluacion,
                        'fecha_vence':this.fecha_vence,
                        'normativa_espanol':this.normativaes,                        
                    }).then(function (response) {
                        me.listarRevalidacion(1,'','','','','','');
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                this.listado=1;
            },
            ActualizarCarne(){
                let me = this;
                    axios.put('/revalidacion/carneactualizar',
                    {
                        'id':this.idrevalidacion,
                        'iddesignacion': this.iddesignacion,
                        'idpersona': this.idpersona,
                        'numero': this.numero,
                        'persona': this.persona,
                        'pdsi': this.pdsi,
                        'empresa': this.empresa,
                        'designacion': this.designacion,
                        'equipo': this.equipo,
                        'cond_equipo': this.cond_equipo,
                        'nivel': this.nivel,
                        'foto': this.foto,
                        'revalidacion':this.revalidacion,
                        'fecha_emision':this.fecha_emision,
                        'fecha_reevaluacion':this.fecha_reevaluacion,
                        'fecha_vence':this.fecha_vence,
                        'normativa_espanol':this.normativaes,                        
                    }).then(function (response) {
                        me.cerrarModal();
                        me.listarRevalidacion(1,'','','','','','');
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarCarneA(){
                let me = this;
                    axios.put('/revalidacion/carneactualizarA',{
                        'id': this.idrevalidacion,
                        'nombrescarne': this.nombrescarne,
                        'empresacarne': this.empresacarne,
                        'designacioncarne': this.designacioncarne,
                        }).then(function (response) {
                    me.cerrarModal();
                    me.listarRevalidacion(1,'','','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            buscarPersona(){
                let me=this;
                var url= '/persona/buscarPersona?filtro=' + me.dni;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas;

                    if (me.arrayPersona.length>0){
                        me.persona=me.arrayPersona[0]['nombre']+' '+me.arrayPersona[0]['apellido'];
                        me.nombre=me.arrayPersona[0]['nombre'];
                        me.idpersona=me.arrayPersona[0]['id'];
                        me.apellido=me.arrayPersona[0]['apellido'];
                        me.dni=me.arrayPersona[0]['dni'];
                        me.empresa=me.arrayPersona[0]['empresa'];
                        me.foto=me.arrayPersona[0]['imagen'];
                    }
                    else{
                        me.articulo='No existe Profesional';
                        me.idpersona=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cerrarModal(){
                    this.modal = 0;
                    this.tituloModal = '';
                    this.idusuario= '';
            },
            buscarDesignacion(){
                let me=this;
                var url= '/designacion/buscarDesignacion?filtro=' + me.iddesignacion;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDesignacion = respuesta.designaciones;

                    if (me.arrayDesignacion.length>0){
                        //me.designacion=me.arrayDesignacion[0]['designacion_ingles'];
                        //me.designacion_espanol=me.arrayDesignacion[0]['designacion_espanol'];
                        //me.normativa=me.arrayDesignacion[0]['normativa_ingles'];
                        me.normativaes=me.arrayDesignacion[0]['normativa_espanol'];
                    }
                    else{
                        me.normativa='No existe Profesional';
                        me.iddesignacion=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            fecha (d){
                return moment(d).format("YYYY-MM-DD");
            },
            fechahoy (){
                return moment().format("YYYY-MM-DD");
            },
            desactivarRevalidacion(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to deactivate this Card?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/revalidacion/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarRevalidacion(1,'','','','','','');
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
            activarRevalidacion(id){
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
                    axios.put('/revalidacion/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarRevalidacion(1,'','','','','','');
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
            MirarResumen(){
                this.listado=1;
                this.persona= '';
                this.iddesignacion='';
                this.idpersona='';
                this.numero='';
                this.persona='';
                this.pdsi='';
                this.empresa='';
                this.designacion='';
                this.equipo='';
                this.normativaes='';
                this.nivel='';
                this.revalidacion='';
                this.revalidaciones='';
                this.fecha_emision='';
                this.fecha_reevaluacion='';
                this.fecha_vence='';
                this.normativa_espanol='';
                this.nombrescarne='';
                this.empresacarne='';
                this.designacioncarne='';
                this.estado='';
                this.cond_equipo='';
            },
            buscarPersona(){
                let me=this;
                var url= '/persona/buscarPersona?filtro=' + me.dni;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas;

                    if (me.arrayPersona.length>0){
                        me.persona=me.arrayPersona[0]['nombre']+' '+me.arrayPersona[0]['apellido'];
                        me.nombre=me.arrayPersona[0]['nombre'];
                        me.idpersona=me.arrayPersona[0]['id'];
                        me.apellido=me.arrayPersona[0]['apellido'];
                        me.dni=me.arrayPersona[0]['dni'];
                        me.empresa=me.arrayPersona[0]['empresa'];
                    }
                    else{
                        me.articulo='No existe Profesional';
                        me.idpersona=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            fecha (d){
                return moment(d).format("YYYY-MM-DD");
            },
            cambiarPagina(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para visualizar la data de esa pagina 
                me.listarRevalidacion(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado);
            },
            vistaPrevia(){
                this.listado=2;
            
            },
            
            regreso_actualizacion(){
                this.listado=0;
            },
            generateCerti(){
                let me = this;
                    axios.put('/certificado/generateCerti',
                    {
                        'id': this.certificado_id,
                        'persona_id': this.persona_id,
                        'lote_id': this.lote_id,
                        
                    }).then(function (response) {
                        me.listarRevalidacion(1,'','','','','','');
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                this.listado=1;
            },            
            validarRevision(){
                    this.errorRevision=0;
                    this.errorMostrarMsjRevision =[];

                    if(!this.idusuario) this.errorMostrarMsjRevision.push("It cant be empty.");
                    if(this.errorMostrarMsjRevision.length) this.errorRevision = 1;
                    return this.errorRevision;
           
            },
            Verdetalle(modelo, accion, data = []){
                this.selectTipo_Certificado();
                this.listado=0;
                this.selectPersona();
                this.selectDesignacionOperador();
                this.selectDesignacionRigger();
                this.selectDesignacionSupervisor();
                this.selectDesignacionInspector();
                switch(modelo){
                    case "revalidacion":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.tituloModal = 'Generate New Card';
                                    this.tipoAccion= 2;
                                    this.tipo_certificado_id=5;
                                    this.iddesignacion='';
                                    this.idpersona='';
                                    this.numero='';
                                    this.persona='';
                                    this.pdsi='';
                                    this.empresa='';
                                    this.designacion='';
                                    this.equipo='';
                                    this.normativaes='';
                                    this.nivel='';
                                    this.revalidacion=1;
                                    this.revalidaciones='';
                                    this.fecha_emision='';
                                    this.fecha_reevaluacion='';
                                    this.fecha_vence='';
                                    this.normativa_espanol='';
                                    this.nombrescarne='';
                                    this.empresacarne='';
                                    this.designacioncarne='';
                                    this.estado='';
                                    this.cond_equipo=1;
                                    break;
                                }
                                case 'editar':
                                {
                                    this.tituloModal = 'Preview View';
                                    this.tipoAccion= 3;
                                    this.idrevalidacion=data['id'];
                                    this.tipo_certificado_id=5;
                                    this.iddesignacion=data['iddesignacion'];
                                    this.idpersona=data['idpersona'];
                                    this.numero=data['numero'];
                                    this.persona=data['persona'];
                                    this.pdsi=data['pdsi'];
                                    this.empresa=data['empresa'];
                                    this.designacion=data['designacion'];
                                    this.nivel=data['nivel'];
                                    this.revalidacion=data['revalidacion'];
                                    this.fecha_emision=data['fecha_emision'];
                                    this.fecha_reevaluacion=data['fecha_reevaluacion'];
                                    this.fecha_vence=data['fecha_vence'];
                                    this.normativaes=data['normativa_espanol'];
                                    this.nombrescarne=data['nombrescarne'];
                                    this.empresacarne=data['empresacarne'];
                                    this.designacioncarne=data['designacioncarne'];
                                    this.estado=data['estado'];
                                    this.cond_equipo=data['cond_equipo'];
                                    this.equipo=data['equipo'];                                   
                                    break;
                                }
                                case 'ver':
                                {
                                    this.tituloModal = 'Preview View';
                                    this.tipoAccion= 1;
                                    this.idrevalidacion=data['id'];
                                    this.tipo_certificado_id=data['idtipo_certificado'];  
                                    this.iddesignacion=data['iddesignacion'];
                                    this.idpersona=data['idpersona'];
                                    this.numero=data['numero'];
                                    this.persona=data['persona'];
                                    this.pdsi=data['pdsi'];
                                    this.empresa=data['empresa'];
                                    this.designacion=data['designacion'];
                                    this.equipo=data['equipo'];
                                    this.nivel=data['nivel'];
                                    this.revalidacion=data['revalidacion'];
                                    this.fecha_emision=data['fecha_emision'];
                                    this.fecha_reevaluacion=data['fecha_reevaluacion'];
                                    this.fecha_vence=data['fecha_vence'];
                                    this.normativaes=data['normativa_espanol'];
                                    this.nombrescarne=data['nombrescarne'];
                                    this.empresacarne=data['empresacarne'];
                                    this.designacioncarne=data['designacioncarne'];
                                    this.estado=data['estado'];
                                    this.cond_equipo=data['cond_equipo'];  
                                    
                                    break;
                                }
                            }
                        }
                }
            }
        },
        mounted() {
           this.listarRevalidacion(1,this.bpdsi,this.bempresa,this.bnumero,this.bnpersona,this.bapersona,this.btipo_certificado);
        }
    }
</script>
<style>
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