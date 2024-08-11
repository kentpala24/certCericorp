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
                        <i class="fa fa-align-justify"></i> CERTIFICATES BATCH
                        
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">Batch Request Name: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bnombre" @keyup.enter="listarLote(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="form-control" placeholder="Batch Request Name" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">Applicant: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bsolicitante" @keyup.enter="listarLote(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="form-control" placeholder="Applicant" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Approver: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="baprobador" @keyup.enter="listarLote(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="form-control" placeholder="Approver"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Authorizer: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bautorizacion" @keyup.enter="listarLote(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="form-control" placeholder="Authorizer"></div>
                                    <button type="submit" @click="listarLote(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div> 
                                </div>
                            </div>
                        
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Number</th>
                                    <th>Name</th>
                                    <th>Applicant</th>
                                    <th>Approver</th>
                                    <th>Authorizer</th>
                                    <th>Authorization D.</th>
                                    <th>Start Code</th>
                                    <th>End Code</th>
                                    <th>Quantity</th>
                                    <th>Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="lote in arrayLote" :key="lote.id">
                                    
                                    <td v-text="lote.numero"></td>
                                    <td v-text="lote.nombre"></td>
                                    <td v-text="lote.solicitante"></td>
                                    <td v-text="lote.aprobador"></td>
                                    <td v-text="lote.autorizacion"></td>
                                    <td v-text="fecha(lote.fecha_autorizacion)"></td>
                                    <td v-text="'P - '+lote.start_code"></td>
                                    <td v-text="'P - '+lote.end_code"></td>
                                    <td v-text="lote.cantidad"></td>
                                    <td v-text="lote.stock"></td>
                                    
                                </tr>
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page >1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,bnombre,bsolicitante,baprobador,bautorizacion)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,bnombre,bsolicitante,baprobador,bautorizacion)" v-text="page"></a>
                                </li>
                                
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,bnombre,bsolicitante,baprobador,bautorizacion)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Enter Name">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Applicant</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="solicitante" class="form-control" placeholder="Enter Applicant">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Approver:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="aprobador" class="form-control" placeholder="Approver">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Reviewer</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="revisor" class="form-control" placeholder="Reviewer">
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Quantity</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cantidad" class="form-control" placeholder="Quantity">
                                    </div>
                                </div>
                                
                                <div v-show="errorLote" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjLote" :key="error" v-text="error">

                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Close</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarLote()">Save</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarLote()">To update</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
           
            
            
        </main>
</template>

<script>
import moment from 'moment'
    export default {
        data() {
            return{
                //Tabla
            lote_id: 0,
            autorizacion_lote_id : '',
            numero : '',
            nombre : '',
            solicitante : '',
            aprobador : '',
            bnombre : '',
            bsolicitante : '',
            baprobador : '',
            bautorizacion : '',
            revisor : '',
            fecha_autorizacion : '',
            cantidad : '',
            arrayLote : [],
            //Datos
            modal:0,
            tituloModal : '',
            tipoAccion:0,
            errorLote : 0,
            errorMostrarMsjLote : [],
            pagination : {
                'total'         : 0,
                'current_page'  : 0,
                'per_page'      : 0,
                'last_page'     : 0,
                'from'          : 0,
                'to'            : 0,
            },
            offset : 3,
            criterio : 'solicitante',
            buscar : ''
            }
        },
        computed : {
            isActived: function(){
                return this.pagination.current_page;
            },
            pagesNumber: function(){
                if(!this.pagination.to){
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if(from<1){
                    from = 1;
                }

                var to = from + (this.offset * 2);
                if(to>= this.pagination.last_page){
                    to = this.pagination.last_page;
                }

                var pagesArray=[];
                while(from <= to){
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;
            }
        },
        methods : {
            listarLote (page,bnombre,bsolicitante,baprobador,bautorizacion) {
                let me=this;
                var url='/lote?page=' + page + '&buscar=' + bnombre + '&criterio=' + bsolicitante + '&aprobador=' + baprobador + '&autorizador=' + bautorizacion;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayLote = respuesta.lotes.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            fecha (d){
                return moment(d).format("YYYY-MM-DD");
            },
            cambiarPagina (page,bnombre,bsolicitante,baprobador,bautorizacion){
                let me = this;
                //Actuializa la página actual
                me.pagination.current_page=page;
                me.listarLote(page,bnombre,bsolicitante,baprobador,bautorizacion);

            },
            registrarLote(){
                if (this.validarLote()){
                    return;
                }
                let me=this;
                axios.post('/lote/registrar',{
                    'nombre': this.nombre,
                    'solicitante': this.solicitante,
                    'aprobador': this.aprobador,
                    'revisor': this.revisor,
                    'cantidad': this.cantidad

                }).then(function (response){
                    me.cerrarModal();
                    me.listarLote(1,'','','','');
                })
                .catch(function (error){
                    console.log(error);
                });
                
            },
            
            
            validarLote(){
                this.errorLote=0;
                this.errorMostrarMsjLote=[];
                if (!this.nombre) this.errorMostrarMsjLote.push("Lot name cannot be empty");
                if (!this.cantidad) this.errorMostrarMsjLote.push("Lot quantity cannot be empty");
                if(this.errorMostrarMsjLote.length) this.errorLote = 1;

                return this.errorLote;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal = '';
                this.usuario_id = '';
                this.nombre = '';
                this.apellido = '';
                this.dni = '';
                this.email = '';
                this.celular = '';
                this.grado_instruccion = '';
                this.ip = '';
                this.imagen = '';
                
            },
            abrirModal(modelo,accion, data=[]){
                switch(modelo){
                    case "lote":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Register Lot';
                                        this.numero = '';
                                        this.nombre = '';
                                        this.solicitante = '';
                                        this.aprobador = '';
                                        this.revisor = '';
                                        this.fecha_autorizacion = '';
                                        this.cantidad = '';
                                        this.tipoAccion=1;
                                        break;
                                    }
                                
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarLote(1,this.bnombre,this.bsolicitante,this.baprobador,this.bautorizacion);
        }
    }
</script>
<style>
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }

    .mostrar{
        display:list-item !important;
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
