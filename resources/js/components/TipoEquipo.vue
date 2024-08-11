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
                        <i class="fa fa-align-justify"></i> TIPO DE EQUIPOS
                        <button type="button" @click="abrirModal('tipoEquipo','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-md-4 form-control-label" for="tipoCertificado">Tipo Certificado: </label> 
                                    <div class="col-md-5">
                                        <input type="text" v-model="tipo_certificado" @keyup.enter="listarTipoCert(1,tipo_certificado,cod_tipo_cert,tipo_equipo)" class="form-control" placeholder="TIPO CERTIFICADO" >
                                    </div>
                                    <label class="col-md-4 form-control-label" for="codiCertificado">Código Tipo Certificado: </label> 
                                    <div class="col-md-5">
                                        <input type="text" v-model="cod_tipo_cert" @keyup.enter="listarTipoCert(1,tipo_certificado,cod_tipo_cert,tipo_equipo)" class="form-control" placeholder="CODIGO TIPO CERTIFICADO" >
                                    </div>
                                    <label class="col-md-4 form-control-label" for="tipoCertificado">Tipo Equipo: </label> 
                                    <div class="col-md-5">
                                        <input type="text" v-model="tipo_equipo" @keyup.enter="listarTipoCert(1,tipo_certificado,cod_tipo_cert,tipo_equipo)" class="form-control" placeholder="TIPO EQUIPO" >
                                    </div>
                                    <button type="submit" @click="listarTipoCert(1,tipo_certificado,cod_tipo_cert,tipo_equipo)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                            
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Tipo Certificado</th>
                                    <th>Cod. Tipo Cert.</th>
                                    <th>Tipo Equipo</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="tipoEquipo in arrayTipoCert" :key="tipoEquipo.id">
                                    <td>
                                        <button type="button" @click="abrirModal('tipoEquipo','actualizar',tipoEquipo)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="tipoEquipo.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarTipoCert(tipoEquipo.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarTipoCert(tipoEquipo.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        
                                    </td>
                                    <td v-text="tipoEquipo.tipo_certificado"></td>
                                    <td v-text="tipoEquipo.cod_tipo_cert"></td>
                                    <td v-text="tipoEquipo.tipo_equipo"></td>
                                    <td>
                                        <div v-if="tipoEquipo.condicion">
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
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,tipo_certificado,cod_tipo_cert,tipo_equipo)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,tipo_certificado,cod_tipo_cert,tipo_equipo)" v-text="page"></a>
                                </li>
                                
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,tipo_certificado,cod_tipo_cert,tipo_equipo)">Sig</a>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Certificado</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nTipo_certificado" class="form-control" placeholder="Tipo Certificado">
                                        
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">Cod. Tipo. Cert.</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nCod_tipo_cert" class="form-control" placeholder="Cod. Tipo. Cert.">
                                        
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo Equipo</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nTipo_equipo" class="form-control" placeholder="Tipo Equipo">
                                        
                                    </div>
                                </div>
                                

                                <div v-show="errorFirma" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjFirma" :key="error" v-text="error">

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
            tipoCert_id: 0,
            usuario_id : '',
            nombre : '',
            imagen : '',
            imagenMiniatura: '',
            ip : '',
            condicion : '',
            arrayTipoCert : [],
            modal:0,
            tituloModal : '',
            tipoAccion:0,
            errorFirma : 0,
            errorMostrarMsjFirma : [],
            pagination : {
                'total'         : 0,
                'current_page'  : 0,
                'per_page'      : 0,
                'last_page'     : 0,
                'from'          : 0,
                'to'            : 0,
            },
            offset : 3,
            //Filtros
            tipo_certificado : '',
            cod_tipo_cert : '',
            tipo_equipo : '',
            nTipo_certificado : '',
            nCod_tipo_cert : '',
            nTipo_equipo : ''

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
            },
            imagenes(){
                return this.imagenMiniatura;
            },
        },
        methods : {
            listarTipoCert(page,tipo_certificado,cod_tipo_cert,tipo_equipo) {
                let me=this;
                var url='/tipoEquipo?page=' + page + '&tipoCertificado=' + tipo_certificado + '&codTipoCert=' + cod_tipo_cert+ '&tipoEquipo=' + tipo_equipo;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayTipoCert = respuesta.tipoEquipos.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            cambiarPagina (page,tipo_certificado,cod_tipo_cert,tipo_equipo){
                let me = this;
                //Actuializa la página actual
                me.pagination.current_page=page;
                me.listarTipoCert(page,tipo_certificado,cod_tipo_cert,tipo_equipo);

            },
            formData(){
                let me=this;
                const formData = new FormData;
                formData.set('id',this.tipoCert_id)
                formData.set('tipo_certificado',this.nTipo_certificado)
                formData.set('cod_tipo_cert',this.nCod_tipo_cert)
                formData.set( 'tipo_equipo', this.nTipo_equipo)
                if(this.tipoCert_id==''){
                    axios.post('/tipoEquipo/registrar',formData).then(function (response){
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarTipoCert(1,'','','');
                })
                .catch(function (error){
                    console.log(error);
                });    
                }
                else{
                    axios.post('/tipoEquipo/actualizar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarTipoCert(1,'','','');
                })
                .catch(function (error){
                    console.log(error);
                });

                }
                

            },
            desactivarTipoCert(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: '¿Quieres Desactivar Tipo de Equipo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/tipoEquipo/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarTipoCert(1,'','','');
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
            activarTipoCert(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: '¿Quieres Activar Tipo de Equipo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/tipoEquipo/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarTipoCert(1,'','','');
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
            validarFirma(){
                this.errorFirma=0;
                this.errorMostrarMsjFirma=[];
                if (!this.nombre) this.errorMostrarMsjFirma.push("Person's name cannot be empty");
                if (!this.imagen) this.errorMostrarMsjFirma.push("The image of the Person cannot be empty");
                if(this.errorMostrarMsjFirma.length) this.errorFirma= 1;

                return this.errorFirma;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal = '';
                this.nCod_tipo_cert = '';
                this.nTipo_certificado = '';
                this.nTipo_equipo = '';
                this.ip = '';
            },
            abrirModal(modelo,accion, data=[]){
                switch(modelo){
                    case "tipoEquipo":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Registrar Tipo Certificado';
                                        this.usuario_id = '';
                                        this.nTipo_certificado = '';
                                        this.nCod_tipo_cert = '';
                                        this.nTipo_equipo = '';
                                        this.tipoAccion=1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal=1;
                                        this.tituloModal="Actualizar Tipo Certificado";
                                        this.tipoAccion=2;
                                        this.tipoCert_id=data['id'];
                                        this.nCod_tipo_cert = data['cod_tipo_cert'];
                                        this.nTipo_equipo = data['tipo_equipo'];
                                        this.nTipo_certificado = data['tipo_certificado'];
                                        this.ip = data['ip'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarTipoCert(1,this.tipo_certificado,this.cod_tipo_cert,this.tipo_equipo);
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
