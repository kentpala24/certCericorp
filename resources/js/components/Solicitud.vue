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
                        <i class="fa fa-align-justify"></i> BATCH REQUEST
                        <button type="button" @click="abrirModal('sol','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;New
                        </button>
                    </div>
                   <div class="card-body">
                     <div class="form-group row">
                        <div class="col-md-7">
                            <div class="form-group row">
                                <label class="col-md-4 form-control-label" for="nombre">Batch Name: </label> 
                        <div class="col-md-6">
                                <input type="text" v-model="criterio" @keyup.enter="listarSol(1,criterio,solicitante)" class="form-control" placeholder="Name" ></div>
                                <label class="col-md-4 form-control-label" for="solicitante">Professional: </label> 
                        <div class="col-md-6">
                                <input type="text" v-model="solicitante" @keyup.enter="listarSol(1,criterio,solicitante)" class="form-control" placeholder="Professional"></div>
                                <button type="submit" @click="listarSol(1,criterio,solicitante)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                       </div>
                        </div></div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Professional</th>
                                    <th>Name</th>
                                    <th>Stock Request</th>
                                    <th>Date</th>
                                    <th>Quantity</th>
                                    <th>Comments</th>
                                    <th>Last request </th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="sol in arraySol" :key="sol.id">
                                    <td>
                        
                                        
                                        <template v-if="sol.condicion==1">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarSol(sol.id)">
                                          <i class="icon-trash"></i>
                                        </button>
                                        </template>
                                         <template v-else-if="sol.condicion==0">
                                        <button type="button" class="btn btn-info btn-sm" @click="activarSol(sol.id)">
                                          <i class="icon-check"></i>
                                        </button>
                                        </template>
                                    </td>
                                    <td v-text="sol.nusuario+' '+sol.apellido"></td>
                                    <td v-text="sol.nombre"></td>
                                    <td v-html="sol.stock_actual"></td>
                                    <td v-text="fecha(sol.created_at)"></td>
                                    <td v-text="sol.cantidad"></td>
                                    <td v-text="sol.comentario"></td>
                                    <td v-text="sol.ultima_solicitud"></td>
                                    <td> <div v-if="sol.condicion==0">
                                        <span class="badge badge-danger">Cancelled</span>
                                        </div>
                                        <div v-else-if="sol.condicion==1">
                                        <span class="badge badge-secondary">Pending</span>
                                        </div>
                                        <div v-else-if="sol.condicion==2">
                                        <span class="badge badge-success">Approved</span>
                                        </div>
                                        <div v-else-if="sol.condicion==3">
                                        <span class="badge badge-danger">Not approved</span>
                                        </div>
                                        <div v-else-if="sol.condicion==4">
                                        <span class="badge badge-warning">Reviewed</span>
                                        </div>
                                        <div v-else-if="sol.condicion==5">
                                        <span class="badge badge-danger">Review Canceled</span>
                                        </div>
                                        <div v-else-if="sol.condicion==6">
                                        <span class="badge badge-success">Authorized</span>
                                        </div>
                                        <div v-else-if="sol.condicion==7">
                                        <span class="badge badge-danger">Not authorized</span>
                                        </div>
                                        </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,criterio,solicitante)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,criterio,solicitante)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,criterio,solicitante)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Batch Name</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Batch Name">    
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="descripcion-input">Stock Request</label>
                                    <div class="col-md-9">
                                        <tr v-for="lotes in arrayLote" :key="lotes.id">
                                            <td v-text="lotes.stock+' Certificates | '+lotes.numero+' '+lotes.nombre"></td>
                                        </tr> 
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Last request</label>
                                    <div class="col-md-9">
                                        <input type="date" class="form-control" placeholder="Last request" v-model="arrayUsol" disabled>
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Quantity</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cantidad" class="form-control" placeholder="Quantity" autofocus>    
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Comments</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="comentario" class="form-control" placeholder="Comments" >    
                                    </div>
                                </div>
                                <div v-show="errorSol" class="form-group row div-error"> 
                                    <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjSol" :key="error" v-text="error">
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Close</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarSol()">Request</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarSol()">To update</button>
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
                sol_id: 0,
                nombre: '',
                stock_actual: '',
                ultima_solicitud: '',
                cantidad: '',
                comentario: '',
                condicion: '',
                arraySol: [],
                arrayUsol: [],
                arrayLote: [],
                modal : 0,
                tituloModal:'',
                tipoAccion : 0 ,
                errorSol : 0,
                errorMostrarMsjSol : [],
                pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
                },
                offset : 3,
                criterio : '',
                solicitante :'',
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
            listarSol (page,criterio,solicitante){
                let me=this;
                var url= '/solicitud?page=' + page + '&solicitante='+ solicitante + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arraySol = respuesta.soli_lot.data;
                    me.arrayUsol = respuesta.ultima;
                    me.arrayLote = respuesta.stock_real;
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
            cambiarPagina(page,criterio,solicitante){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para visualizar la data de esa pagina 
                me.listarSol(page,criterio,solicitante);
            },
            registrarSol(){
                    if(this.validarSol()){
                            return;
                    }
                    let me = this;
                    axios.post('/solicitud/registrar',{
                        'nombre': this.nombre,
                        'stock_actual': this.stock_actual,
                        'ultima_solicitud': this.ultima_solicitud,
                        'cantidad': this.cantidad,
                        'comentario': this.comentario
                    }).then(function (response) {
                    me.cerrarModal();
                    me.listarSol(1,'','');
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            
            desactivarSol(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to deactivate this Request?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'To accept',
                    cancelButtonText: 'cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/solicitud/desactivar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarSol(1,'','');
                        swalWithBootstrapButtons.fire(
                        'Disabled',
                        'Successfully Deactivated',
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
                        'error'
                        )
                    }
                    })
            },
            activarSol(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to activate the application?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'To accept',
                    cancelButtonText: 'cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/solicitud/activar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarSol(1,'','');
                        swalWithBootstrapButtons.fire(
                        'Activated',
                        'Successfully activated',
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
            validarSol(){
                    this.errorSol=0;
                    this.errorMostrarMsjSol =[];

                    if(!this.nombre) this.errorMostrarMsjSol.push("The request name cannot be empty.");
                    if(this.errorMostrarMsjSol.length) this.errorSol = 1;
                    return this.errorSol;
           },
            cerrarModal(){
                    this.modal = 0;
                    this.tituloModal = '';
                    this.nombre= '';
                    this.stock_actual= '';
                    this.ultima_solicitud= '';
                    this.cantidad= '';
                    this.comentario= '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "sol":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Request Registration';
                                    this.nombre= moment().format("MMMM")+' - '+moment().format("YYYY");
                                    this.stock_actual= '';
                                    this.ultima_solicitud= '';
                                    this.cantidad= '200';
                                    this.comentario= 'Without Stock';
                                    this.tipoAccion = 1;
                                    break;
                                }
                                
                            }
                        }
                }
            }
        },
        mounted() {
           this.listarSol(1,this.solicitante,this.criterio);
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