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
                        <i class="fa fa-align-justify"></i> SIGNATURES
                        <button type="button" @click="abrirModal('firma','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;New
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Name</option>                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarFirma(1,buscar,criterio)" class="form-control" placeholder="Type here">
                                    <button type="submit" @click="listarFirma(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                                </div>
                            </div>
                            
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Name</th>
                                    <th>Plantilla</th>
                                    <th>Firma</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="firma in arrayFirma" :key="firma.id">
                                    <td>
                                        <button type="button" @click="abrirModal('firma','actualizar',firma)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="firma.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarFirma(firma.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarFirma(firma.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        
                                    </td>
                                    <td v-text="firma.nombre"></td>
                                    <td>
                                        <figure>
                                        <img width="50" height="50" :src="'/storage/'+firma.imagen2"  name="perfil">
                                        </figure>
                                    </td>
                                    <td>
                                        <figure>
                                        <img width="50" height="50" :src="'/storage/'+firma.imagen"  name="perfil">
                                        </figure>
                                    </td>
                                    <td>
                                        <div v-if="firma.condicion">
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre Firma</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Enter Name">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Datos del Firmante</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombreF" class="form-control" placeholder="Enter Name">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo de Certificado</label>
                                    <div class="col-md-9">
                                        <textarea v-model="tipo" cols="20" rows="1" class="form-control"></textarea>
                                        
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Entidad Certificadora</label>
                                    <div class="col-md-9">
                                        <textarea v-model="entidad" cols="20" rows="1" class="form-control"></textarea>
                                        
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input"># Certificado</label>
                                    <div class="col-md-9">
                                        <textarea v-model="certificado" cols="20" rows="1" class="form-control"></textarea>
                                        
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Otros Datos</label>
                                    <div class="col-md-9">
                                        <textarea v-model="otros" cols="20" rows="1" class="form-control"></textarea>
                                        
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Plantilla sin Firma</label>
                                    <div class="col-md-9">
                                        <input type="file" @change="obtenerImagen2" name="perfil" class="form-control" placeholder="Upload Image">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Plantilla con Firma</label>
                                    <div class="col-md-9">
                                        <input type="file" @change="obtenerImagen" name="perfil" class="form-control" placeholder="Upload Image">
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input"></label>
                                    <figure>
                                        <img width="200" height="200" :src="imagenes"  name="perfil" alt="Foto de Persona">
                                    </figure>
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
            firma_id: 0,
            usuario_id : '',
            nombre : '',
            nombreF : '',
            tipo : '',
            entidad : '',
            certificado : '',
            otros : '',
            imagen : '',
            imagen2 : '',
            imagenMiniatura: '',
            ip : '',
            condicion : '',
            arrayFirma : [],
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
            criterio : 'nombre',
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
            },
            imagenes(){
                return this.imagenMiniatura;
            },
        },
        methods : {
            listarFirma(page,buscar,criterio) {
                let me=this;
                var url='/firmaC?page=' + page + '&buscar=' + buscar + '&criterio=' + criterio;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayFirma = respuesta.firmas.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            cambiarPagina (page,buscar,criterio){
                let me = this;
                //Actuializa la página actual
                me.pagination.current_page=page;
                me.listarFirma(page,buscar,criterio);

            },
            obtenerImagen(e){
                
               this.imagen = e.target.files[0];
               var reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }
            },
            obtenerImagen2(e){
                
                this.imagen2 = e.target.files[0];
                var reader = new FileReader();
                 reader.readAsDataURL(e.target.files[0]);
                 reader.onload = (e) => {
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
                formData.set('id',this.firma_id)
                formData.set('image',this.imagen)
                formData.set('image2',this.imagen2)
                formData.set( 'nombre', this.nombre)
                formData.set( 'nombreF', this.nombreF)
                formData.set( 'entidad', this.entidad)
                formData.set( 'tipo', this.tipo)
                formData.set( 'certificado', this.certificado)
                formData.set( 'otros', this.otros)
                formData.set('ip', this.ip)
                if(this.firma_id==''){
                    axios.post('/firmaC/registrar',formData).then(function (response){
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarFirma(1,'','nombre');
                })
                .catch(function (error){
                    console.log(error);
                });    
                }
                else{
                    axios.post('/firmaC/actualizar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarFirma(1,'','nombre');
                })
                .catch(function (error){
                    console.log(error);
                });

                }
                

            },
            registrarFirma(){
                if (this.validarFirma()){
                    return;
                }
                let me=this;
                axios.post('/firmaC/registrar',{
                    'nombre': this.nombre,
                    'imagen': this.imagen,
                    'ip': this.ip
                }).then(function (response){
                    me.cerrarModal();
                    me.listarFirma(1,'','nombre');
                })
                .catch(function (error){
                    console.log(error);
                });
                
            },
            actualizarFirma(){
                if (this.validarFirma()){
                    return;
                }
                let me=this;
                axios.put('/firmaC/actualizar',{
                    'nombre': this.nombre,
                    'imagen': this.imagen,
                    'ip': this.ip,
                    'id': this.firma_id,
                }).then(function (response){
                    me.cerrarModal();
                    me.listarFirma(1,'','nombre');
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            desactivarFirma(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to disable this signature?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/firmaC/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarFirma(1,'','nombre');
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
            activarFirma(id){
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
                    axios.put('/firmaC/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarFirma(1,'','nombre');
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
                this.usuario_id = '';
                this.nombre = '';
                this.imagen = '';
                this.imagen2 = '';
                this.ip = '';
            },
            abrirModal(modelo,accion, data=[]){
                switch(modelo){
                    case "firma":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Register signature';
                                        this.usuario_id = '';
                                        this.nombre = '';
                                        this.imagen = '';
                                        this.imagen2 = '';
                                        this.imagenMiniatura = '';                                       
                                        this.ip = '';
                                        this.tipoAccion=1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal=1;
                                        this.tituloModal="Update signature";
                                        this.tipoAccion=2;
                                        this.firma_id=data['id'];
                                        this.nombreF = data['nombreF'];
                                        this.nombre = data['nombre'];
                                        this.entidad = data['entidad'];
                                        this.tipo = data['tipo'];
                                        this.certificado = data['certificado'];
                                        this.otros = data['otros'];
                                        this.imagen = '';
                                        this.imagen2 = '';
                                        this.imagenMiniatura = '';
                                        this.ip = data['ip'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarFirma(1,this.buscar,this.criterio);
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
