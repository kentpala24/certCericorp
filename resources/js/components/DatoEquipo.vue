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
                        <i class="fa fa-align-justify"></i> Datos Equipos
                        <button type="button" @click="abrirModal('datoEquipo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label" for="tipoCertificado">Cliente: </label> 
                                    <div class="col-md-5">
                                        <v-select
                                            :options="arrayCliente"
                                            label="cliente"
                                            :reduce="cliente => cliente.id"
                                            v-model="idCliente"
                                            placeholder="Seleccionar Cliente"
                                        ></v-select>
                                    </div>
                                    <label class="col-md-4 form-control-label" for="codiCertificado">Marca: </label> 
                                    <div class="col-md-5">
                                        <input type="text" v-model="marca" @keyup.enter="listarDatoCertificado(1,idCliente,marca,modelo)" class="form-control" placeholder="Marca" >
                                    </div>
                                    <label class="col-md-4 form-control-label" for="tipoCertificado">Modelo: </label> 
                                    <div class="col-md-5">
                                        <input type="text" v-model="modelo" @keyup.enter="listarDatoCertificado(1,idCliente,marca,modelo)" class="form-control" placeholder="Modelo" >
                                    </div>
                                    <button type="submit" @click="listarDatoCertificado(1,idCliente,marca,modelo)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                            
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Cliente</th>
                                    <th>Fabricante</th>
                                    <th>Marca</th>
                                    <th>Modelo</th>
                                    <th>Serie</th>
                                    <th>Año F.</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="datoEquipo in arrayDatosEquipo" :key="datoEquipo.id">
                                    <td>
                                        <button type="button" @click="abrirModal('datoEquipo','actualizar',datoEquipo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="datoEquipo.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarDesignacion(datoEquipo.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarDesignacion(datoEquipo.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        
                                    </td>
                                    <td v-text="datoEquipo.cliente"></td>
                                    <td v-text="datoEquipo.fabricante"></td>
                                    <td v-text="datoEquipo.marca+' '+datoEquipo.modelo"></td>
                                    <td v-text="datoEquipo.capacidad"></td>
                                    <td v-text="datoEquipo.serie"></td>
                                    <td v-text="datoEquipo.anio"></td>
                                    <td>
                                        <div v-if="datoEquipo.condicion">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Cliente</label>
                                    <div class="col-md-9">
                                        <v-select
                                            :options="arrayClienteR"
                                            label="cliente"
                                            :reduce="cliente => cliente.id"
                                            v-model="idClienteN"
                                            placeholder="Seleccionar Cliente"
                                        ></v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Equipo</label>
                                    <div class="col-md-9">
                                        <v-select
                                            :options="arrayTipoCert"
                                            label="tipo_equipo"
                                            :reduce="tipo_equipo => tipo_equipo.id"
                                            v-model="idTipoEquipo"
                                            placeholder="Seleccionar Tipo Equipo"
                                        ></v-select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Fabricante</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="fabricanteN" class="form-control" placeholder="Ingresar Fabricante de Equipo">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Marca</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="marcaN" class="form-control" placeholder="Ingresar Marca de Equipo">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Modelo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="modeloN" class="form-control" placeholder="Modelo de Equipo">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Serie</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="serieN" class="form-control" placeholder="Serie de Equipo">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Capacidad Máxima Nominal</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="capacidad" class="form-control" placeholder="Capacidad Máxima Nominal">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Codigo Interno</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codInternoN" class="form-control" placeholder="Codigo Interno">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Año de Fabricacion</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="anioN" class="form-control" placeholder="Año de Fabricación">
                                        
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
import vSelect from 'vue-select'
    export default {
        components: { vSelect },
        data() {
            return{
            tipo_certificado_id: 0,
            usuario_id : '',
            designacion_id : '',
            designacion_ingles : '',
            designacion_espanol : '',
            identifica: '',
            color : '',
            normativa_ingles : '',
            normativa_espanol : '',

            arrayDatosEquipo : [],
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
            //Buscador
            idCliente : '',
            marca : '',
            modelo : '',
            arrayCliente:[],
            arrayClienteR:[],
            arrayTipoCert:[],
            idTipoEquipo:'',
            //Nuevo Registro
            idEquipo:'',
            idClienteN:0,
            marcaN:'',
            modeloN:'',
            serieN:'',
            capacidad:'',
            codInternoN:'',
            fabricanteN:'',
            anioN:''
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
            listarDatoCertificado(page,idCliente,marca,modelo) {
                this.selectCliente();
                let me=this;
                var url='/datoEquipo?page=' + page + '&id_cliente=' + idCliente + '&marca=' + marca + '&modelo=' + modelo;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDatosEquipo = respuesta.datoEquipos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            selectCliente(){
                let me=this;
                var url='/clientes/selectCliente';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayCliente = [{ id: '', cliente: 'Todos' }, ...respuesta.clientes];
                    me.arrayClienteR = respuesta.clientes;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectTipoEquipo(){
                let me=this;
                var url='/tipoEquipo/selectTipoEquipo';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayTipoCert = respuesta.tipoEquipos;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            cambiarPagina (page,idCliente,marca,modelo){
                let me = this;
                //Actuializa la página actual
                me.pagination.current_page=page;
                me.listarDatoCertificado(page,idCliente,marca,modelo);

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
                formData.set('id',this.idEquipo)
                formData.set( 'id_cliente', this.idClienteN)
                formData.set( 'marca', this.marcaN)
                formData.set( 'modelo', this.modeloN)
                formData.set( 'serie', this.serieN)
                formData.set( 'capacidad', this.capacidad)
                formData.set( 'cod_interno', this.codInternoN)
                formData.set( 'fabricante', this.fabricanteN)
                formData.set( 'anio', this.anioN)
                formData.set( 'idTipoEquipo', this.idTipoEquipo)
                if(this.idEquipo==''){
                    axios.post('/datoEquipo/registrar',formData).then(function (response){
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarDatoCertificado(1,'','','');
                })
                .catch(function (error){
                    console.log(error);
                });    
                }
                else{
                    axios.post('/datoEquipo/actualizar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarDatoCertificado(1,'','','');
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
                    axios.put('/designacion/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarDatoCertificado(1,'','','');
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
                    axios.put('/designacion/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarDatoCertificado(1,idCliente,marca,modelo);
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
                if (!this.identifica) this.errorMostrarMsjDesignacion.push("Llenar Indentifica");
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
                this.color = '';
                this.normativa_ingles = '';
                this.normativa_espanol = '';
            },
            abrirModal(modelo,accion, data=[]){
                this.selectTipoEquipo();
                switch(modelo){
                    case "datoEquipo":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Registrar Nuevo Equipo';
                                        this.usuario_id = '';
                                        this.idEquipo = '';
                                        this.idClienteN = '';
                                        this.marcaN = '';
                                        this.modeloN = '';
                                        this.serieN = '';
                                        this.capacidad = '';
                                        this.codInternoN = '';
                                        this.fabricanteN = '';
                                        this.anioN = '';                                        this.tipoAccion=1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        console.log(data['id_cliente']);
                                        this.modal=1;
                                        this.tituloModal="Actualizar Equipos";
                                        this.tipoAccion=2;
                                        this.idEquipo = data['id'];
                                        this.idClienteN = Number(data['id_cliente']);
                                        this.marcaN = data['marca'];
                                        this.modeloN = data['modelo'];
                                        this.serieN = data['serie'];
                                        this.codInternoN = data['cod_interno'];
                                        this.fabricanteN = data['fabricante'];
                                        this.capacidad = data['capacidad'];
                                        this.anioN = data['anio'];   
                                        this.idTipoEquipo = data['id_tipo_equipo'];   
                                        this.ip = data['ip'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarDatoCertificado(1,this.idCliente,this.marca,this.modelo);
            
        }
    }
</script>
<style>
@import '~vue-select/dist/vue-select.css';
.modal-content {
  width: auto; /* Elimina el 100% para permitir un ajuste automático */
  position: relative; /* Usa relative en lugar de absolute */
  max-width: 100%; /* Asegura que el contenido no exceda el ancho de la pantalla */
}

.mostrar {
  display: block; /* Usar block en lugar de list-item */
  opacity: 1;
  position: fixed; /* Usa fixed en lugar de absolute para asegurar que el modal esté fijo en la pantalla */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow-y: auto; /* Asegura el desplazamiento vertical */
  background-color: rgba(60, 41, 41, 0.48); /* Usa rgba para la transparencia */
}

.modal-dialog {
  max-width: 60%; /* Ajusta el ancho del modal */
  margin: 1.75rem auto; /* Ajusta el margen para centrar verticalmente */
}

@media (max-width: 768px) {
  .modal-dialog {
    max-width: 90%;
  }
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
