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
                        <i class="fa fa-align-justify"></i> DIGITAL CERTIFICATES   
                    </div>
                    <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">PDSI: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bpdsi" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="PDSI" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">Company: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bempresa" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Company" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Nº Certificate: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bnumero" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Nº Certificate"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Professional Name: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bnpersona" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Name Professional"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Professional Surname: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bapersona" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Surname Professional"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Certificate type: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="btipo_certificado" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Certificate type"></div>
                                    <button type="submit" @click="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div> 
                                </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Cards</th>
                                    <th>PDSI / Batch Nº</th>
                                    <th>Nº Certificate</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Certificate type </th>
                                    <th>Equipment(s)</th>
                                    <th>Level</th>
                                    <th>Issue date</th>
                                    <th>Expiration date</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr v-for="certificado in arrayCertificado" :key="certificado.id">
                                        <td>
                                        <template v-if="certificado.estado==5">
                                            <button type="button" @click="Verdetalle('certificado','actualizar',certificado)" class="btn btn-info btn-sm" >
                                            <i class="icon-eye"></i>
                                            </button> 
                                        </template>                                            
                                    </td>
                                    <td v-html="certificado.pdsi+'<br>'+certificado.numero"></td>
                                    <div v-if="certificado.certificado==0">
                                        <td>Without Issuing</td>
                                    </div>
                                    <div v-else>
                                        <td v-text="'P - '+certificado.certificado"></td>
                                    </div>
                                    <td v-text="certificado.nombre"></td>
                                    <td v-html="certificado.apellido"></td>
                                    <td v-text="certificado.designacion+' '+certificado.tipo_certificados"></td>
                                    <td v-html="certificado.equipo"></td>
                                    <td v-text="certificado.level"></td>
                                    <td v-text="certificado.fecha_emision7"></td>
                                    <td v-text="certificado.fecha_expiracion"></td>
                                    <td> <div v-if="certificado.condicion==1">
                                        <span class="badge badge-secondary">To be issued</span>
                                        </div>
                                        <div v-else-if="certificado.fecha_expiracion<fechahoy()">
                                        <span class="badge badge-danger">Expired</span>
                                        </div>
                                        <div v-else-if="certificado.condicion==0">
                                        <span class="badge badge-secondary">Canceled</span>
                                        </div>
                                        <div v-else-if="certificado.condicion==2">
                                        <span class="badge badge-success">Issued</span>
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
                            <div class="col-md-7"> 
                                <div class="form-group">
                                    <strong><label v-text="'ID: '+ num_dni"></label><br>
                                    <label v-text="'Profesional:'+persona"></label><br>
                                    <label v-text="'Company: '+empresa"></label></strong><br>                                      
                                </div>  
                            </div>
                            <div class="col-md-5"> 
                                <div class="form-group">
                                    <strong><label v-text="'# Certificate: P-'+certificado"></label><br>
                                    <label v-text="'Level: '+level"></label><br>
                                    <label v-text="'Emision Date: '+fecha_emision7"></label></strong><br>                                     
                                </div>  
                            </div>
                        </div>
                        <div class="form-group row border">
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Certificate type :</label>
                                    <select class="form-control" v-model="tipo_certificado_id">
                                            <option value="0">Select a</option>
                                            <option v-for="tipo in arrayTipo_certificado" v-bind:key="tipo.id" :value="tipo.id" v-text="tipo.nombre"></option>
                                    </select>
                                    <label>Designation in Certificate:</label>
                                    <input type="text" v-model="designacioncert" class="form-control">
                                    <label>Designation in Card:</label>
                                <template v-if="tipo_certificado_id==5">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionOperador" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_espanol"></option>
                                    </select>
                                </template>
                                <template v-if="tipo_certificado_id==6">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionRigger" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_espanol"></option>
                                    </select>
                                </template>

                                <template v-if="tipo_certificado_id==7">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionSupervisor" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_espanol"></option>
                                    </select>
                                </template>

                                <template v-if="tipo_certificado_id==8">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionInspector" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_espanol"></option>
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
                                        <textarea v-model="equipo" cols="80" rows="5" class="form-control"></textarea>
                                    </template>
                                    <template v-if="cond_equipo==2">
                                        EN: <textarea v-model="equipo" cols="75" rows="2" class="form-control"></textarea>
                                        ES: <textarea v-model="equipoes" cols="75" rows="2" class="form-control"></textarea>
                                    </template>
                                    </div>
                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Normative English:<button @click="buscarDesignacion()" class="btn btn-primary">...</button></label>
                                    <input type="text" v-model="normativa" class="form-control">
                                    <label>Normative Spanish:</label>
                                    <input type="text" v-model="normativaes" class="form-control">
                                </div> 
                            </div>
                            </div>
                            
                       
                         
                        <div class="form-group row">
                     <button type="button" class="btn btn-danger" @click="MirarResumen()">Cancel</button>&nbsp;&nbsp;
                     <button type="button" class="btn btn-danger" @click="GenerateCarne()">Card Generate</button>
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
                idcarne:0,
                persona_id: 0,
                tipo_certificado_id:0,
                firma_id:0,
                lote_id:0,
                certificado_id:0,
                iddesignacion:0,
                dni:'',
                num_dni:'',
                nombre:'',
                apellido:'',
                persona: '',
                nombre_lote: '',
                cond_equipo: 1,
                dias: '',
                numero: '',
                pdsi:'',
                empresa:'',
                certificado:'',
                designacion:'',
                equipo:'',
                tipo_certificados:'',
                level:'',
                horas:'',
                normativa:'',
                qr:'',
                condicion:'',
                fecha_emision:'',
                fecha_emision2:'',
                fecha_emision3:'',
                fecha_emision4:'',
                fecha_emision5:'',
                fecha_emision6:'',
                fecha_emision7:'',
                fecha_revalidacion:'',
                fecha_expiracion:'',
                firma_nombre: '',
                description:'',
                cabecera:'',
                fecha_total:'',
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
                arrayCertificado: [],
                arrayLote: [],
                arrayFirma: [],
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
                criterio : 'certificado',
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
            listarCertificado(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado){
                let me=this;
                var url= '/consulta?page=' + page + '&bpdsi='+ bpdsi+ '&bempresa='+ bempresa
                + '&bnumero='+ bnumero+ '&bnpersona='+ bnpersona + '&bapersona='+ bapersona+ '&btipo_certificado='+ btipo_certificado;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCertificado = respuesta.certificados.data;
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
            cargarPdfedicion(id){
                window.open('/certificado/certificadoPdf/'+id,'_blanck')
            },
            cargarPdfemision(id){
                window.open('/certificado/certificadoPdfEmision/'+id,'_blanck')
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
            GenerateCarne(){
                let me = this;
                    axios.put('/emitir/Carne',
                    {
                        'idcertificado': this.certificado_id,
                        'idcarne': this.idcarne,
                        'iddesignacion': this.iddesignacion,
                        'tipo_certificado_id': this.tipo_certificado_id,
                        'persona_id': this.persona_id,
                        'lote_id': this.lote_id,
                        'equipoes': this.equipoes,
                        'equipo': this.equipo,
                        'normativaes': this.normativaes,
                        'fecha_emision7': this.fecha_emision7,
                        'fecha_expiracion': this.fecha_expiracion,
                        'persona':this.persona,
                        'empresa':this.empresa,
                        'level':this.level,
                        'cond_equipo':this.cond_equipo,

                        
                    }).then(function (response) {
                        me.listarCertificado(1,'','','','','','');
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                this.listado=1;
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
                        me.normativa=me.arrayDesignacion[0]['normativa_ingles'];
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

            MirarResumen(){
                this.listado=1;
                this.persona= '';
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
                        me.persona_id=me.arrayPersona[0]['id'];
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
                me.listarCertificado(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado);
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
                        me.listarCertificado(1,'','','','','','');
                    
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
                this.selectFirma();
                this.selectLote();
                this.selectPersona();
                this.selectDesignacionOperador();
                this.selectDesignacionRigger();
                this.selectDesignacionSupervisor();
                this.selectDesignacionInspector();
                switch(modelo){
                    case "certificado":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.tituloModal = 'Generate New Certificate ';
                                    this.tipoAccion= 2;
                                    this.persona_id='';
                                    this.tipo_certificado_id='';
                                    this.firma_id='';
                                    this.lote_id='';
                                    this.certificado_id='';
                                    this.dias=1;
                                    this.cond_equipo=1;
                                    //this.nombre='';
                                    //this.apellido='';
                                    this.nombre_lote='';
                                    this.numero='';
                                    this.pdsi='';
                                    //this.empresa='';
                                    this.certificado='';
                                    this.designacion='';
                                    this.equipo='';
                                    this.tipo_certificados='';
                                    this.level='';
                                    this.horas='';
                                    this.normativa='';
                                    this.qr='';
                                    this.condicion='';
                                    this.fecha_emision='';
                                    this.fecha_emision2='';
                                    this.fecha_emision3='';
                                    this.fecha_emision4='';
                                    this.fecha_emision5='';
                                    this.fecha_emision6='';
                                    this.fecha_emision7='';
                                    this.firma_nombre='';
                                    this.cabecera='';
                                    this.fecha_total='';
                                    break;
                                }
                                case 'actualizar':
                                {
                                    this.tituloModal = 'Preview View';
                                    this.tipoAccion= 1;
                                    this.persona_id= data['idpersona'];
                                    this.tipo_certificado_id= data['idtipo_certificado'];
                                    this.firma_id= data['idfirma'];
                                    this.lote_id= data['idlote'];
                                    this.certificado_id= data['id'];
                                    this.idcarne= data['idcarne'];
                                    this.nombre= data['nombre'];
                                    this.apellido= data['apellido'];
                                    this.persona= data['persona'];
                                    this.nombre_lote= data['nombre_lote'];
                                    this.numero= data['numero'];
                                    this.lote= data['numero'+'nombre_lote'];
                                    this.pdsi= data['pdsi'];
                                    this.empresa= data['empresa'];
                                    this.num_dni=data['dni'];
                                    this.certificado= data['certificado'];
                                    this.designacion= data['designacion'];
                                    this.designacioncert=data['designacioncert'];
                                    this.iddesignacion= data['iddesignacion'];
                                    this.equipo= data['equipo'];
                                    this.equipoes= data['equipoes'];
                                    this.dias=data['dias'];
                                    this.cond_equipo=data['cond_equipo'];
                                    this.tipo_certificados= data['tipo_certificados'];
                                    this.level= data['level'];
                                    this.horas= data['horas'];
                                    this.normativa= data['normativa'];
                                    this.qr= data['qr'];
                                    this.condicion= data['condicion'];
                                    this.fecha_emision= data['fecha_emision'];
                                    this.fecha_emision2= data['fecha_emision2'];
                                    this.fecha_emision3= data['fecha_emision3'];
                                    this.fecha_emision4= data['fecha_emision4'];
                                    this.fecha_emision5= data['fecha_emision5'];
                                    this.fecha_emision6= data['fecha_emision6'];
                                    this.fecha_emision7= data['fecha_emision7'];
                                    this.fecha_expiracion=data['fecha_expiracion'];
                                    this.firma_nombre= data['firma_nombre'];
                                    this.description=data['description'];
                                    this.cabecera=data['cabecera'];
                                    this.fecha_total=data['fecha'];
                                    
                                    break;
                                }
                            }
                        }
                }
            }
        },
        mounted() {
           this.listarCertificado(1,this.bpdsi,this.bempresa,this.bnumero,this.bnpersona,this.bapersona,this.btipo_certificado);
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