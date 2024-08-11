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
                        <i class="fa fa-align-justify"></i> Designacion
                        <button type="button" @click="abrirModal('designacion','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="idtipo_certificado">Tipo de Certificado</option>
                                      <option value="designacion_espanol">Designacion Español</option>
                                      <option value="designacion_ingles">Designacion Ingles</option>
                                                                          </select>
                                    <template v-if="criterio == 'idtipo_certificado'">
                                        <select class="form-control" v-model="buscar">
                                            <option value="0">Select a Tipo Cetificado</option>
                                            <option value="1">OPERADOR</option>
                                            <option value="2">SEÑALERO</option>
                                            <option value="3">APAREJADOR</option>
                                            <option value="4">SUPERVISOR</option>
                                        </select>
                                    </template>
                                    <template v-else>
                                        <input type="text" v-model="buscar" @keyup.enter="listarDesignacion(1,buscar,criterio)" class="form-control" placeholder="Type here">
                                    </template>
                                    
                                    <button type="submit" @click="listarDesignacion(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                            
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Designacios (es)</th>
                                    <th>Tipo de Certificado</th>
                                    <th>Normativa</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="designacion in arrayDesignacion" :key="designacion.id">
                                    <td>
                                        <button type="button" @click="abrirModal('designacion','actualizar',designacion)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="designacion.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarDesignacion(designacion.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarDesignacion(designacion.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        
                                    </td>
                                    <td v-text="designacion.designacion_espanol"></td>
                                    <td v-text="designacion.nombre"></td>
                                    <td v-text="designacion.normativa_espanol"></td>
                                    <td>
                                        <div v-if="designacion.estado">
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
                                <li class="page-item" v-if="pagination.current_page >1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,buscar,criterio)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
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
                            <form @submit.prevent="formData" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo de Certificado</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="tipo_certificado_id">
                                            <option value="0">Select a Tipo Cetificado</option>
                                            <option v-for="tipo in arrayTipo_certificado" :key="tipo.id" :value="tipo.id" v-text="tipo.nombre"></option>
                                        </select>                                      
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-9">
                                        <input type="hidden" v-model="designacion_ingles" class="form-control" placeholder="Ingresar Designacion en Inglés">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Designacion en Español</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="designacion_espanol" class="form-control" placeholder="Ingresar Designacion en Español">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Identifica en Español</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="identifica" class="form-control" placeholder="Identifica Español">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Formato de Certificación</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="identifica_ingles" class="form-control" placeholder="Identifica Ingles">
                                        
                                    </div>
                                </div>
                                        <input type="hidden" v-model="color" class="form-control" placeholder="Identifica Ingles">
                                        
                                        
                                <div class="form-group row">
                                    
                                    <div class="col-md-9">
                                        <input type="hidden" v-model="normativa_ingles" class="form-control" placeholder="Normativa en Inglés">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Normativa en Español</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="normativa_espanol" class="form-control" placeholder="Normativa en Español">
                                        
                                    </div>
                                </div>
                                

                                <div v-show="errorDesignacion" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjDesignacion" :key="error" v-text="error">

                                        </div>
                                    </div>

                                </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal()">Close</button>
                                <button v-if="tipoAccion==1" class="btn btn-primary">Save</button>
                                <button v-if="tipoAccion==2" class="btn btn-primary">To update</button>
                            </div>
                            </form>
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
        data() {
            return{
            tipo_certificado_id: 0,
            usuario_id : '',
            designacion_id : '',
            designacion_ingles : '',
            designacion_espanol : '',
            identifica: '',
            identifica_ingles: '',
            color : '',
            normativa_ingles : '',
            normativa_espanol : '',

            arrayDesignacion : [],
            arrayTipo_certificado: [],
            modal:0,
            tituloModal : '',
            tipoAccion:0,
            errorDesignacion : 0,
            errorMostrarMsjDesignacion : [],
            pagination : {
                'total'         : 0,
                'current_page'  : 0,
                'per_page'      : 0,
                'last_page'     : 0,
                'from'          : 0,
                'to'            : 0,
            },
            offset : 3,
            criterio : 'designacion_ingles',
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
            listarDesignacion(page,buscar,criterio) {
                let me=this;
                var url='/designacionC?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacion = respuesta.designaciones.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            selectTipo_Certificado(){
                let me=this;
                var url='/tipo/selectTipoCCertifica';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayTipo_certificado = respuesta.tipos;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            cambiarPagina (page,buscar,criterio){
                let me = this;
                //Actuializa la página actual
                me.pagination.current_page=page;
                me.listarDesignacion(page,buscar,criterio);

            },
            obtenerImagen(e){
                
               this.imagen = e.target.files[0];
               var reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }
            },
            cargarImagen(file){
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }
                reader.readAsDataURL(file);

            },
            formData(){
                let me=this;
                const formData = new FormData;
                formData.set('id',this.designacion_id)
                formData.set( 'idtipo_certificado', this.tipo_certificado_id)
                formData.set( 'designacion_ingles', this.designacion_ingles)
                formData.set( 'designacion_espanol', this.designacion_espanol)
                formData.set( 'identifica', this.identifica)
                formData.set( 'identifica_ingles', this.identifica_ingles)
                formData.set( 'color', this.color)
                formData.set( 'normativa_ingles', this.normativa_ingles)
                formData.set( 'normativa_espanol', this.normativa_espanol)
                if(this.designacion_id==''){
                    axios.post('/designacionC/registrar',formData).then(function (response){
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarDesignacion(1,'','designacion_ingles');
                })
                .catch(function (error){
                    console.log(error);
                });    
                }
                else{
                    axios.post('/designacionC/actualizar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarDesignacion(1,'','designacion_ingles');
                })
                .catch(function (error){
                    console.log(error);
                });

                }
                

            },
            
            desactivarDesignacion(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to disable this designation?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/designacionC/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarDesignacion(1,'','designacion_ingles');
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
            activarDesignacion(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to activate this signature?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/designacionC/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarDesignacion(1,'','designacion_ingles');
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
            validarDesignacion(){
                this.errorDesignacion=0;
                this.errorMostrarMsjDesignacion=[];
                if (!this.designacion_ingles) this.errorMostrarMsjDesignacion.push("Llenar Designación en Ingles");
                if (!this.designacion_espanol) this.errorMostrarMsjDesignacion.push("Llenar Designación en Español");
                if (!this.identifica) this.errorMostrarMsjDesignacion.push("Llenar Indentifica en Ingles");
                if (!this.identifica_ingles) this.errorMostrarMsjDesignacion.push("Llenar Indentifica");
                if (!this.normativa_ingles) this.errorMostrarMsjDesignacion.push("Llenar Normativa en Ingles");
                if (!this.normativa_espanol) this.errorMostrarMsjDesignacion.push("Llenar Normativa en Español");
                if (!this.tipo_certificado_id) this.errorMostrarMsjDesignacion.push("Llenar Tipo de Certificado");
                if(this.errorMostrarMsjDesignacion.length) this.errorDesignacion= 1;

                return this.errorDesignacion;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal = '';
                this.usuario_id = '';
                this.designacion_id = '';
                this.tipo_certificado_id = '';
                this.designacion_ingles = '';
                this.designacion_espanol = '';                                       
                this.identifica = '';
                this.identifica_ingles = '';
                this.color = '';
                this.normativa_ingles = '';
                this.normativa_espanol = '';
            },
            abrirModal(modelo,accion, data=[]){
                this.selectTipo_Certificado();
                switch(modelo){
                    case "designacion":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Register signature';
                                        this.usuario_id = '';
                                        this.designacion_id = '';
                                        this.tipo_certificado_id = '';
                                        this.designacion_ingles = '';
                                        this.designacion_espanol = '';                                       
                                        this.identifica = '';
                                        this.identifica_ingles = '';
                                        this.color = '';
                                        this.normativa_ingles = '';
                                        this.normativa_espanol = '';
                                        this.tipoAccion=1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal=1;
                                        this.tituloModal="Update signature";
                                        this.tipoAccion=2;
                                        this.designacion_id=data['id'];
                                        this.tipo_certificado_id=data['idtipo_certificado'];
                                        this.designacion_ingles = data['designacion_ingles'];
                                        this.designacion_espanol = data['designacion_espanol'];
                                        this.identifica=data['identifica'];
                                        this.identifica_ingles=data['identifica_ingles'];
                                        this.color=data['color'];
                                        this.normativa_ingles = data['normativa_ingles'];
                                        this.normativa_espanol = data['normativa_espanol'];

                                        this.designacion_id=data['id'];
                                        this.designacion_ingles = data['designacion_ingles'];
                                        this.ip = data['ip'];



                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarDesignacion(1,this.buscar,this.criterio);
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
