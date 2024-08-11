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
                        <i class="fa fa-align-justify"></i>BATCH REQUEST APPROVAL
                    </div>
                    <template v-if="listado">
                    <!-- Listado -->
                     <div class="card-body">
                   <div class="form-group row">
                        <div class="col-md-11">
                            <div class="form-group row">
                     <label class="col-md-4 form-control-label" for="nombre">Batch Request Name: </label> 
                        <div class="col-md-5">
                                <input type="text" v-model="nombreS" @keyup.enter="listarAprobacion(1,nombreS,solicitante,aprobador)" class="form-control" placeholder="Name" ></div>
                    <label class="col-md-4 form-control-label" for="nombre">Applicant: </label> 
                        <div class="col-md-5">
                                <input type="text" v-model="solicitante" @keyup.enter="listarAprobacion(1,nombreS,solicitante,aprobador)" class="form-control" placeholder="Applicant" ></div>
                    <label class="col-md-4 form-control-label" for="solicitante">Approver: </label> 
                        <div class="col-md-5">
                                <input type="text" v-model="aprobador" @keyup.enter="listarAprobacion(1,nombreS,solicitante,aprobador)" class="form-control" placeholder="Approver"></div>
                                <button type="submit" @click="listarAprobacion(1,nombreS,solicitante,aprobador)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                       </div> 
                            </div>
                        </div>

                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Approved</th>
                                    <th>Batch Request Name</th>
                                    <th>Applicant</th>
                                    <th>Request Date</th>
                                    <th>Quantity</th>
                                    <th>Last Request </th>
                                    <th>Approver</th>
                                    <th>Approved quantity</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="solicitud in arraySolicitante" :key="solicitud.id">
                                    <td>
                        
                                        <button type="button" @click="Verdetalle('aprobacion','actualizar',solicitud)" class="btn btn-info btn-sm" >
                                          <i class="icon-eye"></i>
                                        </button> &nbsp; 
                                        
                                    </td>
                                    <td v-text="solicitud.nombre"></td>
                                    <td v-text="solicitud.nusuario+' '+solicitud.apellido"></td>
                                    <td v-text="fecha(solicitud.created_at)"></td>
                                    <td v-text="solicitud.cantidad"></td>
                                    <td v-text="fecha(solicitud.ultima_solicitud)"></td>
                                    <td>Pending approval</td>
                                    <td>Pending approval</td>
                                    <td> <div v-if="solicitud.condicion==1">
                                        <span class="badge badge-secondary">Pending</span>
                                        </div>
                                    </td>
                                </tr>

                                <tr v-for="aprobacion in arrayAprobacion" :key="aprobacion.id">
                                    <td>                                     
                                    </td>
                                    <td v-text="aprobacion.nlote"></td>
                                    <td v-text="aprobacion.solicitante"></td>
                                    <td v-text="fecha(aprobacion.created_at)"></td>
                                    <td v-text="aprobacion.cantidad"></td>
                                    <td v-text="aprobacion.ultima_solicitud"></td>
                                    <td v-text="aprobacion.nombre_aprobador+' '+aprobacion.apellido_aprobador"></td>
                                    <td v-text="aprobacion.cantidad_aprob"></td>
                                    <td><div v-if="aprobacion.condicion==0">
                                        <span class="badge badge-danger">Not approved</span>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==1">
                                        <span class="badge badge-success">Approved</span>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==2">
                                        <span class="badge badge-warning">reviewed</span>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==3">
                                        <span class="badge badge-danger">Review Canceled</span>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==4">
                                        <span class="badge badge-success">Authorized</span>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==5">
                                        <span class="badge badge-danger">Not Authorized</span>
                                        </div>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,nombreS,solicitante,aprobador)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,nombreS,solicitante,aprobador)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,nombreS,solicitante,aprobador)">Sig</a>
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
                                    <h5><label v-text="nusuario+' '+apellido"></label></h5>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Lot Name: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <input type="text" v-model="nombre" class="form-control" disabled>
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
                                        <li><h5><label v-text="'Stock Request: '"></label></h5></li>
                                        </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <h5><label v-html="stock_actual"></label></h5></div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Last Batch Date: '"></label></h5></li></ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h5><label v-text="fecha(ultima_solicitud)"></label></h5>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Requested Quantity: '"></label></h5></li>
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
                                    <input type="text" v-model="comentario" class="form-control" disabled>
                                    <input type="hidden" v-model="solicitud_id" class="form-control" disabled>
                                </div>  
                            </div>
                        
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Approved quantity: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" v-model="cantidad" class="form-control">
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <ul class="form-group">
                                        <li><h5><label v-text="'Approved Comentary: '"></label></h5></li>
                                    </ul>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <textarea v-model="comentario" cols="80" rows="5"></textarea>
                                </div>  
                            </div>
                        </div>
                        </form>   
                        <div class="form-group row">
                            <button type="button" class="btn btn-danger" @click="Desaprobar()">Disapprove</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="Aprobar()">Approve</button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-secondary" @click="MirarResumen()">Cancel</button>
                        </div>             
                    </div>
                    </template>
                <!-- Fin ejemplo de tabla Listado -->
            </div></div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar': modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Quantity</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cantidad" class="form-control" placeholder="Quantity">    
                                    </div>
                                </div>
                                <div v-show="errorAprobacion" class="form-group row div-error"> 
                                    <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjAprobacion" :key="error" v-text="error">
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" @click="cerrarModal()">Disapprove</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarAprobacion()">Approve</button>
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
        data(){
            return{
                //Datos del Listado
                aprobacion_id: 0,
                solicitud_id: 0,
                nombre: '',
                nusuario: '',
                apellido: '',
                created_at: '',
                stock_actual: '',
                cantidad: '',
                ultima_solicitud: '',
                comentario: '',
                usuario_id: 0,
                cantidad_aprob: '',
                arrayAprobacion: [],
                arraySolicitante:[],
                //
                modal : 0,
                tituloModal:'',
                tipoAccion : 0 ,
                errorAprobacion : 0,
                errorMostrarMsjAprobacion : [],
                listado: 1,
                pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
                },
                offset : 3,
                nombreS : '',
                solicitante :'',
                aprobador :'',
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
           listarAprobacion (page,nombreS,solicitante,aprobador){
                let me=this;
                var url= '/aprobacion?page=' + page + '&nombreS='+ nombreS+ '&solicitante='+ solicitante+ '&aprobador=' +aprobador;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    me.arrayAprobacion = respuesta.aprobaciones.data;
                    me.arraySolicitante = respuesta.soli_lot;
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
            cambiarPagina(page,nombreS,solicitante,aprobador){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para visualizar la data de esa pagina 
                me.listarAprobacion(page,nombreS,solicitante,aprobador);
            },
            Desaprobar(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure you want to Disapprove the Lot Request?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Disapprove',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.post('/aprobacion/actualizar',
                                    {
                                        'cantidad': this.cantidad,
                                        'comentario': this.comentario,
                                        'id': this.solicitud_id
                                        }).then(function (response) {
                                    me.listarAprobacion(1,'','','');
                                    
                        swalWithBootstrapButtons.fire(
                        'Disapprove',
                        'Lot Request Disapproved',
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
                        'Lot Request Disapproval was canceled',
                        'error'
                        )
                    }
                    })
                    this.listado=1;
            },
            MirarResumen(){
                this.listado=1;
            },
            Aprobar(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure you Approve the Batch request?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Approve',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.post('/aprobacion/registrar',
                                    {
                                        'cantidad': this.cantidad,
                                        'comentario': this.comentario,
                                        'id': this.solicitud_id
                                        }).then(function (response) {
                                    me.listarAprobacion(1,'','','');
                        swalWithBootstrapButtons.fire(
                        'Approved',
                        'Batch Request was successfully approved',
                        'Success'
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
                        'Approval was Canceled',
                        'error'
                        )
                    }
                    })
                    this.listado=1;
            },
            validarAprobacion(){
                    this.errorAprobacion=0;
                    this.errorMostrarMsjAprobacion =[];

                    if(!this.cantidad) this.errorMostrarMsjAprobacion.push("Quantity cannot be empty.");
                    if(this.errorMostrarMsjAprobacion.length) this.errorAprobacion = 1;
                    return this.errorAprobacion;
           },
            
            Verdetalle(modelo, accion, data = []){
                this.listado=0;
                switch(modelo){
                    case "aprobacion":
                        {
                            switch(accion){
                                case 'actualizar':
                                {
                                    this.tituloModal = 'Lot Request Approval Detail';
                                    this.tipoAccion= 2;
                                    this.solicitud_id= data['id'];
                                    this.nombre= data['nombre'];
                                    this.nusuario= data['nusuario'];
                                    this.apellido= data['apellido'];
                                    this.created_at= data['created_at'];
                                    this.stock_actual= data['stock_actual'];
                                    this.cantidad= data['cantidad'];
                                    this.ultima_solicitud= data['ultima_solicitud'];
                                    this.comentario= data['comentario'];
                                    this.usuario_id= '';
                                    this.cantidad_aprob= '';
                                    break;
                                }
                            }
                        }
                }
            }
        },
            
        mounted() {
           this.listarAprobacion(1,this.nombreS,this.solicitante,this.aprobador);
        }
    }
</script>
<style>
    
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }

</style>