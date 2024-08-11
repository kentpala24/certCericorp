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
                        <i class="fa fa-align-justify"></i> TYPE OF CERTIFICATE
                        <button type="button" @click="abrirModal('tipo_certificado','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;New
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                           <label class="col-md-4 form-control-label" for="nombre">Certificate Type Name: </label> 
                        <div class="col-md-6">
                                <input type="text" v-model="buscar" @keyup.enter="listarTipo_certificado(1,buscar,criterio)" class="form-control" placeholder="Name"></div>
                                <button type="submit" @click="listarTipo_certificado(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Name</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tipo_certificado in arrayTipo_certificado" :key="tipo_certificado.id">
                                    <td>
                        
                                        <button type="button" @click="abrirModal('tipo_certificado','actualizar',tipo_certificado)" class="btn btn-warning btn-sm" >
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="tipo_certificado.condicion">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarTipo_certificado(tipo_certificado.id)">
                                          <i class="icon-trash"></i>
                                        </button>
                                        </template>
                                         <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activarTipo_certificado(tipo_certificado.id)">
                                          <i class="icon-check"></i>
                                        </button>
                                        </template>
                                    </td>
                                    <td v-text="tipo_certificado.nombre"></td>
                                    <td> <div v-if="tipo_certificado.condicion">
                                        <span class="badge badge-success">Active</span>
                                        </div>
                                        <div v-else>
                                        <span class="badge badge-danger">Disabled</span>
                                        </div>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,buscar,criterio)">Sig</a>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Certificate Type Name">    
                                    </div>
                                </div>
                                <div v-show="errorTipo_certificado" class="form-group row div-error"> 
                                    <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjTipo_certificado" :key="error" v-text="error">
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Close</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarTipo_certificado()">Save</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarTipo_certificado()">To update</button>
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
    export default {
        data(){
            return{
                tipo_certificado_id: 0,
                nombre: '',
                condicion: '',
                arrayTipo_certificado: [],
                modal : 0,
                tituloModal:'',
                tipoAccion : 0 ,
                errorTipo_certificado : 0,
                errorMostrarMsjTipo_certificado : [],
                pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
                },
                offset : 3,
                criterio : 'nombre',
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
            listarTipo_certificado (page,buscar,criterio){
                let me=this;
                var url= '/tipo?page=' + page + '&buscar='+ buscar;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayTipo_certificado = respuesta.tipos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para visualizar la data de esa pagina 
                me.listarTipo_certificado(page,buscar,criterio);
            },
            registrarTipo_certificado(){
                    if(this.validarTipo_certificado()){
                            return;
                    }
                    let me = this;
                    axios.post('/tipo/registrar',{
                        'nombre': this.nombre
                    }).then(function (response) {
                    me.cerrarModal();
                    me.listarTipo_certificado(1,'','nombre');
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarTipo_certificado(){
                if(this.validarTipo_certificado()){
                            return;
                    }
                    let me = this;
                    axios.put('/tipo/actualizar',{
                        'nombre': this.nombre,
                        'id': this.tipo_certificado_id
                    }).then(function (response) {
                    me.cerrarModal();
                    me.listarTipo_certificado(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
                
            },
            desactivarTipo_certificado(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to disable this type of certificate?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'To accept',
                    cancelButtonText: 'cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/tipo/desactivar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarTipo_certificado(1,'','nombre');
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
            activarTipo_certificado(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to activate this type of certificate?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'To accept',
                    cancelButtonText: 'cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/tipo/activar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarTipo_certificado(1,'','nombre');
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
                        'error'
                        )
                    }
                    })
            },
            validarTipo_certificado(){
                    this.errorTipo_certificadol=0;
                    this.errorMostrarMsjTipo_certificado =[];

                    if(!this.nombre) this.errorMostrarMsjTipo_certificado.push("The name of the Certified Type cannot be empty.");
                    if(this.errorMostrarMsjTipo_certificado.length) this.errorTipo_certificado = 1;
                    return this.errorTipo_certificado;
           },
            cerrarModal(){
                    this.modal = 0;
                    this.tituloModal = '';
                    this.nombre= '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "tipo_certificado":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Register type of certificate';
                                    this.nombre= '';
                                    this.tipoAccion = 1;
                                    break;
                                }
                                case 'actualizar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Update Certificate Type';
                                    this.tipoAccion= 2;
                                    this.tipo_certificado_id= data['id'];
                                    this.nombre= data['nombre'];
                                    break;
                                }
                            }
                        }
                }
            }
        },
        mounted() {
           this.listarTipo_certificado(1,this.buscar,this.criterio);
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