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
                        <i class="fa fa-align-justify"></i> Role
                        <button type="button" @click="abrirModal('rol','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;New
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Name</option>
                                      <option value="descripcion">Description</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarRol(1,buscar,criterio)" class="form-control" placeholder="Search text">
                                    <button type="submit" @click="listarRol(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="rol in arrayRol" :key="rol.id">
                                    <td>
                        
                                        <button type="button" @click="abrirModal('rol','actualizar',rol)" class="btn btn-info btn-sm" >
                                          <i class="icon-eye"></i>
                                        </button> &nbsp;
                                        <template v-if="rol.condicion">
                                        <button type="button" class="btn btn-danger btn-sm" @click="desactivarRol(rol.id)">
                                          <i class="icon-trash"></i>
                                        </button>
                                        </template>
                                         <template v-else>
                                        <button type="button" class="btn btn-info btn-sm" @click="activarRol(rol.id)">
                                          <i class="icon-check"></i>
                                        </button>
                                        </template>
                                    </td>
                                    <td v-text="rol.nombre"></td>
                                    <td v-text="rol.descripcion"></td>
                                    <td> <div v-if="rol.condicion">
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
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Role Name">    
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="descripcion-input">Description</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="descripcion" class="form-control" placeholder="Enter Description">
                                    </div>
                                </div>
                                <div v-show="errorRol" class="form-group row div-error"> 
                                    <div class="text-center text-error">
                                            <div v-for="error in errorMostrarMsjRol" :key="error" v-text="error">
                                            </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Close</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarRol()">Save</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarRol()">To update</button>
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
                rol_id: 0,
                nombre: '',
                descripcion: '',
                condicion: '',
                arrayRol: [],
                modal : 0,
                tituloModal:'',
                tipoAccion : 0 ,
                errorRol : 0,
                errorMostrarMsjRol : [],
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
            listarRol (page,buscar,criterio){
                let me=this;
                var url= '/rol?page=' + page + '&buscar='+ buscar+ '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles.data;
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
                me.listarRol(page,buscar,criterio);
            },
            registrarRol(){
                    if(this.validarRol()){
                            return;
                    }
                    let me = this;
                    axios.post('/rol/registrar',{
                        'nombre': this.nombre,
                        'descripcion': this.descripcion
                    }).then(function (response) {
                    me.cerrarModal();
                    me.listarRol(1,'','nombre');
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            actualizarRol(){
                if(this.validarRol()){
                            return;
                    }
                    let me = this;
                    axios.put('/rol/actualizar',{
                        'nombre': this.nombre,
                        'descripcion': this.descripcion,
                        'id': this.rol_id
                    }).then(function (response) {
                    me.cerrarModal();
                    me.listarRol(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
                
            },
            desactivarRol(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to disable this role?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'To accept!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/rol/desactivar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarRol(1,'','nombre');
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
                        'Your imaginary file is safe :)',
                        'error'
                        )
                    }
                    })
            },
            activarRol(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to activate this role?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'To accept',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/rol/activar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarRol(1,'','nombre');
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
            validarRol(){
                    this.errorRol=0;
                    this.errorMostrarMsjRol =[];
                    if(!this.nombre) this.errorMostrarMsjRol.push("The role name cannot be empty.");
                    if(this.errorMostrarMsjRol.length) this.errorRol = 1;
                    return this.errorRol;
           },
            cerrarModal(){
                    this.modal = 0;
                    this.tituloModal = '';
                    this.nombre= '';
                    this.descripcion= '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "rol":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Register Role';
                                    this.nombre= '';
                                    this.descripcion= '';
                                    this.tipoAccion = 1;
                                    break;
                                }
                                case 'actualizar':
                                {
                                    this.modal = 1;
                                    this.tituloModal = 'Update Role';
                                    this.tipoAccion= 2;
                                    this.rol_id= data['id'];
                                    this.nombre= data['nombre'];
                                    this.descripcion= data['descripcion'];
                                    break;
                                }
                            }
                        }
                }
            }
        },
        mounted() {
           this.listarRol(1,this.buscar,this.criterio);
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