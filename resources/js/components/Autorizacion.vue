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
                        <i class="fa fa-align-justify"></i> CERTIFICATES BATCH RELEASE AUTHORIZATION
                        
                    </div>
                    <template v-if="listado">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">Batch Request Name: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bnombre" @keyup.enter="listarAutorizacion(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="form-control" placeholder="Batch Request Name" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">Applicant: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bsolicitante" @keyup.enter="listarAutorizacion(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="form-control" placeholder="Applicant" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Approver: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="baprobador" @keyup.enter="listarAutorizacion(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="form-control" placeholder="Approver"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Authorizer: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bautorizacion" @keyup.enter="listarAutorizacion(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="form-control" placeholder="Authorizer"></div>
                                    <button type="submit" @click="listarAutorizacion(1,bnombre,bsolicitante,baprobador,bautorizacion)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div> 
                                </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Authorize</th>
                                    <th>Batch Request Name</th>
                                    <th>Applicant</th>
                                    <th>Request Date</th>
                                    <th>Stock Request</th>
                                    <th>Quantity</th>
                                    <th>Approver</th>
                                    <th>Authorizer</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="aprobacion in arrayAprobacion" :key="aprobacion.id">
                                        <td>
                                            <button type="button" @click="Verdetalle('autorizacion','detalle',aprobacion)" class="btn btn-info btn-sm" >
                                          <i class="icon-eye"></i>
                                        </button> &nbsp;
                                    </td>
                                    <td v-text="aprobacion.nlote"></td>
                                    <td v-text="aprobacion.solicitante"></td>
                                    <td v-text="fecha(aprobacion.created_at)"></td>
                                    <td v-html="aprobacion.stock_actual"></td>
                                    <td v-text="aprobacion.cantidad_aprob"></td>
                                    <td v-text="aprobacion.aprobador"></td>
                                    <td>Without authorization</td>
                                    <td> <div v-if="aprobacion.condicion=1">
                                        <span class="badge badge-secondary">Pending</span>
                                        </div>
                                    </td>
                                </tr>

                                    <tr v-for="autorizar in arrayAutorizacion" :key="autorizar.id">
                                        <td>
                                    </td>
                                    <td v-text="autorizar.nlote"></td>
                                    <td v-text="autorizar.solicitante"></td>
                                    <td v-text="fecha(autorizar.created_at)"></td>
                                    <td v-html="autorizar.stock_actual"></td>
                                    <td v-text="autorizar.cantidad_aprob"></td>
                                    <td v-text="autorizar.aprobador"></td>
                                    <td v-text="autorizar.nombre_autorizador+' '+autorizar.apellido_autorizador"></td>
                                    <td> <div v-if="autorizar.condicion==0">
                                        <span class="badge badge-danger">Not authorized</span>
                                        </div>
                                        <div v-else-if="autorizar.condicion==1">
                                        <span class="badge badge-warning">Authorized</span>
                                        </div>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,bnombre,bsolicitante,baprobador,bautorizacion)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,bnombre,bsolicitante,baprobador,bautorizacion)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,bnombre,bsolicitante,baprobador,bautorizacion)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </template>
                <template v-else>
                            <!-- Mostrar Datos -->
                    <div class="card-body">
                        <div class="form-group row border">
                            <h2 v-text="tituloModal"></h2>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row border">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Applicant Person: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h5><label v-text="solicitante"></label></h5>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Batch name: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <input type="text" v-model="nlote" class="form-control" disabled>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Request Date: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <h5><label v-text="fecha(created_at)"></label></h5>                                    
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Stock Request : '"></label></h5></li>
                                        </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h5><label v-html="stock_actual"></label></h5>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Last batch date: '"></label></h5></li></ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                   <input type="text" v-model="ultima_solicitud" class="form-control" disabled>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Requested quantiqy: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" v-model="cantidad" class="form-control" disabled>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Comment: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea v-model="comentario" cols="80" rows="5" disabled></textarea>
                                    <input type="hidden" v-model="aprobacion_id" class="form-control" disabled>
                                    <input type="hidden" v-model="solicitud_id" class="form-control" disabled>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Approver: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" v-model="aprobador" class="form-control" disabled>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Approved quantity: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" v-model="cantidad_aprob" class="form-control" disabled>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Approval date: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h5><label v-text="fecha(f_aprobacion)"></label></h5>
                                </div>  
                            </div>                        
                        
                        </div>
                       
                        </form>   
                        <div class="form-group row">
                            <button type="button" class="btn btn-danger" @click="NoAutorizar()">Not authorize</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="Autorizar()">Authorize batch</button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-secondary" @click="MirarResumen()">Cancel</button>
                        </div>             
                    </div>
                    </template>
                    </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>            
        </main>
</template>

<script>
import moment from 'moment'
    export default {
        data(){
            return{
                //Datos
                solicitud_id:0,
                aprobacion_id:0,
                autorizacion_id: 0,
                solicitante:'',
                nlote:'',
                stock_actual:'',
                ultima_solicitud:'',
                cantidad:'',
                created_at:'',
                aprobador:'',
                bnombre : '',
                bsolicitante : '',
                baprobador : '',
                bautorizacion : '',
                f_aprobacion:'',
                cantidad_aprob:'',
                nombre_autorizador:'',
                apellido_autorizador:'',
                condicion:'',
                autorizacion: '',
                arrayAutorizacion: [],
                arrayAprobacion:[],

                modal : 0,
                tituloModal:'',
                tipoAccion : 0 ,
                listado: 1,
                errorAutorizacion : 0,
                errorMostrarMsjAutorizacion : [],
                pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
                },
                offset : 3,
                criterio : 'autorizacion',
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
            listarAutorizacion (page,bnombre,bsolicitante,baprobador,bautorizacion){
                let me=this;
                var url= '/autorizacion?page=' + page + '&nombre=' + bnombre+ '&solicitante='+ bsolicitante + '&aprobador='+ baprobador + '&autorizacion='+ bautorizacion;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayAutorizacion = respuesta.autorizaciones.data;
                    me.arrayAprobacion = respuesta.aprobaciones;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            fecha (d){
                return moment(d).format("YYYY-MM-DD");
            },
            cambiarPagina(page,bnombre,bsolicitante,baprobador,bautorizacion){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para visualizar la data de esa pagina 
                me.listarAutorizacion(page,bnombre,bsolicitante,baprobador,bautorizacion);
            },
            NoAutorizar(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure you dont authorize the batch release?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'not authorize',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.post('/autorizacion/actualizar',
                                    {
                                        'solicitud_id': this.solicitud_id,
                                        'aprobacion_id': this.aprobacion_id,
                                        }).then(function (response) {
                                    me.listarAutorizacion(1,'','','','');
                                    
                        swalWithBootstrapButtons.fire(
                        'not authorized',
                        'Release of the Lot was not authorized',
                        'success'
                        )

                                }).catch(function (error) {
                                    console.log(error);
                                });

                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'cancelled',
                        'The Non-Authorization for the release of the Lot was canceled',
                        'error'
                        )
                    }
                    })
                    this.listado=1;
            },
            MirarResumen(){
                this.listado=1;
            },
            Autorizar(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to authorize the batch release ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Authorize',
                    cancelButtonText: 'cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.post('/autorizacion/registrar',
                                    {
                                        'solicitud_id': this.solicitud_id,
                                        'aprobacion_id': this.aprobacion_id,
                                        'solicitante': this.solicitante,
                                        'aprobador': this.aprobador,
                                        'cantidad_aprob': this.cantidad_aprob,
                                        'nlote': this.nlote
                                        }).then(function (response) {
                                    me.listarAutorizacion(1,'','','','');
                        swalWithBootstrapButtons.fire(
                        'Authorized',
                        'The release of a new batch of certificates was authorized',
                        'success'
                        )

                                }).catch(function (error) {
                                    console.log(error);
                                });

                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Batch Authorization was canceled',
                        )
                    }
                    })
                    this.listado=1;
            },
            desactivarAutorizacion(id){
               const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure you dont authorize the batch release?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'not authorize',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.post('/autorizacion/actualizar',
                                    {
                                        'solicitud_id': this.solicitud_id,
                                        'aprobacion_id': this.aprobacion_id,
                                        }).then(function (response) {
                                    me.listarAutorizacion(1,'','','','');
                                    
                        swalWithBootstrapButtons.fire(
                        'not authorized',
                        'Release of the Lot was not authorized',
                        'success'
                        )

                                }).catch(function (error) {
                                    console.log(error);
                                });

                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'cancelled',
                        'The Non-Authorization for the release of the Lot was canceled',
                        'error'
                        )
                    }
                    })
                    this.listado=1;
            },
        
            activarAutorizacion(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to authorize the batch release ?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Authorize',
                    cancelButtonText: 'cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/autorizacion/activar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarAutorizacion(1,'','','','');
                        swalWithBootstrapButtons.fire(
                      'Authorized',
                        'The release of a new batch of certificates was authorized',
                        'success'
                        )

                                }).catch(function (error) {
                                    console.log(error);
                                });

                        
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                        )
                    }
                    })
            },
            validarAutorizacion(){
                    this.errorAutorizacion=0;
                    this.errorMostrarMsjAutorizacion =[];

                    if(!this.autorizacion) this.errorMostrarMsjAutorizacion.push("Authorization cannot be empty.");
                    if(this.errorMostrarMsjAutorizacion.length) this.errorAutorizacion= 1;
                    return this.errorAutorizacion;
           },
            cerrarModal(){
                    this.modal = 0;
                    this.tituloModal = '';
                    this.autorizacion= '';
            },
            Verdetalle(modelo, accion, data = []){
                this.listado=0;
                switch(modelo){
                    case "autorizacion":
                        {
                            switch(accion){
                                
                                case 'detalle':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Batch Request Authorization Detail';
                                    this.tipoAccion= 2;
                                    this.solicitud_id= data['idsoli'];
                                    this.aprobacion_id= data['id'];
                                    this.autorizacion_id= data['id'];
                                    this.solicitante= data['solicitante'];
                                    this.nlote= data['nlote'];
                                    this.stock_actual= data['stock_actual'];
                                    this.ultima_solicitud= data['ultima_solicitud'];
                                    this.cantidad= data['cantidad'];
                                    this.comentario= data['comentario'];
                                    this.created_at= data['created_at'];
                                    this.aprobador= data['aprobador'];
                                    this.f_aprobacion= data['f_aprobacion'];
                                    this.cantidad_aprob= data['cantidad_aprob'];
                                    this.nombre_autorizador= data['nombre_autorizador'];
                                    this.apellido_autorizador= data['apellido_autorizador'];
                                    this.condicion= data['condicion'];
                                    this.autorizacion= data['autorizacion'];
                                    break;
                                }
                            }
                        }
                }
            }
        },
        mounted() {
           this.listarAutorizacion(1,this.bnombre,this.bsolicitante,this.baprobador,this.bautorizacion);
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