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
                        <i class="fa fa-align-justify"></i> PROFESSIONAL
                        <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;New
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">Name: </label>
                            <div class="col-md-5">
                                <input type="text" v-model="bnombre" @keyup.enter="listarPersona(1,bnombre,bapellido,bdni,bempresa)" class="form-control" placeholder="Name" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">Surname: </label>
                            <div class="col-md-5">
                                <input type="text" v-model="bapellido" @keyup.enter="listarPersona(1,bnombre,bapellido,bdni,bempresa)" class="form-control" placeholder="Surname" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Nº Document: </label>
                            <div class="col-md-5">
                                    <input type="text" v-model="bdni" @keyup.enter="listarPersona(1,bnombre,bapellido,bdni,bempresa)" class="form-control" placeholder="Nº Document"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Company: </label>
                            <div class="col-md-5">
                                    <input type="text" v-model="bempresa" @keyup.enter="listarPersona(1,bnombre,bapellido,bdni,bempresa)" class="form-control" placeholder="Company"></div>
                                    <button type="submit" @click="listarPersona(1,bnombre,bapellido,bdni,bempresa)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div>
                                </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>DNI</th>
                                    <th>Email</th>
                                    <th>Cell phone</th>
                                    <th>Company</th>
                                    <th>Image</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td>
                                        <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="persona.condicion">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarPersona(persona.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarPersona(persona.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>

                                    </td>
                                    <td v-text="persona.nombre"></td>
                                    <td v-text="persona.apellido"></td>
                                    <td v-text="persona.dni"></td>
                                    <td v-text="persona.email"></td>
                                    <td v-text="persona.celular"></td>
                                    <td v-text="persona.empresa"></td>
                                    <td>
                                        <figure>
                                        <img width="50" height="50" :src="'/storage/'+persona.imagen"  name="perfil">
                                        </figure>
                                    </td>
                                    <td>
                                        <div v-if="persona.condicion">
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
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,bnombre,bapellido,bdni,bempresa)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,bnombre,bapellido,bdni,bempresa)" v-text="page"></a>
                                </li>

                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,bnombre,bapellido,bdni,bempresa)">Sig</a>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Enter Names">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Surname</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido" class="form-control" placeholder="Enter Surname">
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Current company</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="empresa" class="form-control" placeholder="Enter current company">
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Current Company</label>
                                    <div class="col-md-9">
                                        <select name="" id="" v-model="cli_id" @change="inputEmpresa($event)" class="form-control" style="position:absolute; width: 95%; height: 100%;">
                                            <option value="0" disabled selected>Seleccionar</option>
                                            <option v-for="empresa in empresas_all" :key="empresa.cli_id"  :value="empresa.cli_id" v-text="empresa.cli_razon_social + ' - RUC: ' + empresa.cli_nro_ruc"></option>
                                        </select>
                                        <input type="text" class="form-control" v-model="empresa" placeholder="Seleccionar" style="position: relative; width: 95%;">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">DNI:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="dni" class="form-control" placeholder="DNI">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">EMAIL</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nº
driver's license </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="celular" class="form-control" placeholder="# Number license">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Degree of instruction</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="grado_instruccion" class="form-control" placeholder="Degree of instruction">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Image</label>
                                    <div class="col-md-9">
                                        <input type="file" @change="obtenerImagen" name="perfil" class="form-control" placeholder="Upload Image">
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input"></label>

                                </div>
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

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
            persona_id: 0,
            usuario_id : '',
            nombre : '',
            apellido : '',
            empresa : '',
            dni : '',
            email : '',
            celular : '',
            grado_instruccion : '',
            ip : '',
            imagen : '',
            imagenMiniatura:'',
            condicion : '',
            arrayPersona : [],
            //buscador
            bnombre:'',
            bapellido:'',
            bdni:'',
            bempresa:'',

            modal:0,
            tituloModal : '',
            tipoAccion:0,
            errorPersona : 0,
            errorMostrarMsjPersona : [],
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
            buscar : '',
            cli_id: '',
            empresas_all: '',
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
            listarPersona (page,bnombre,bapellido,bdni,bempresa) {
                let me=this;
                var url='/persona?page=' + page + '&bnombre=' + bnombre + '&bapellido=' + bapellido
                + '&bdni=' + bdni + '&bempresa=' + bempresa;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination = respuesta.pagination;
                    me.empresas_all = respuesta.empresas_all;
                    // me.arrayPersona = me.arrayPersona.map(persona => {
                    //     return persona = {...persona,
                    //                         empresa : me.empresas_all
                    //                                   .filter(empresa=>empresa.cli_id == persona.cli_id)[0]
                    //                                   .cli_razon_social}})
                })
                .catch(function (error){
                    console.log(error);
                });
            },

            cambiarPagina(page,bnombre,bapellido,bdni,bempresa){
                let me = this;
                //Actuializa la página actual
                me.pagination.current_page=page;
                me.listarPersona(page,bnombre,bapellido,bdni,bempresa);

            },
            obtenerImagen(e){

               this.imagen = e.target.files[0];
               var reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }

               /*console.log(e.target.files[0])
                var reader = new FileReader();
                reader.readAsDataURL(e.target.files[0]);
                reader.onload = (e) => {
                    this.imagen = e.target.result;
                    this.imagenMiniatura = e.target.result;
                }*/


               //console.log(this.imagen);

                //let file = e.target.files[0];
                //this.imagen=file;
                //this.cargarImagen(file);

            },
            formData(){
                let me=this;
                const formData = new FormData;
                formData.set('id',this.persona_id)
                formData.set('image',this.imagen)
                formData.set( 'nombre', this.nombre)
                formData.set('apellido', this.apellido)
                formData.set('dni', this.dni)
                formData.set('email', this.email)
                formData.set('celular', this.celular)
                formData.set('empresa', this.empresa)
                formData.set('grado_instruccion', this.grado_instruccion)
                formData.set('ip', this.ip)
                formData.set('cli_id', this.cli_id)
                if(this.persona_id==''){
                    axios.post('/persona/registrar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarPersona(1,'','','','');
                })
                .catch(function (error){
                    console.log(error);
                });
                }
                else{
                    axios.post('/persona/actualizar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarPersona(1,'','','','');
                })
                .catch(function (error){
                    console.log(error);
                });
                }
            },
            cargarImagen(file){
                let reader = new FileReader();
                reader.onload = (e) => {
                    this.imagenMiniatura = e.target.result;
                }
                reader.readAsDataURL(file);

            },
            registrarPersona(){
                if (this.validarPersona()){
                    return;
                }
                let me=this;
                axios.post('/persona/registrar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'dni': this.dni,
                    'email': this.email,
                    'celular': this.celular,
                    'grado_instruccion': this.grado_instruccion,
                    'ip': this.ip,
                    'imagen': this.imagen,
                    'empresa': this.empresa.split(' -')[0],
                    'cli_id': this.cli_id

                }).then(function (response){
                    me.cerrarModal();
                    me.listarPersona(1,'','','','');
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            actualizarPersona(){
                if (this.validarPersona()){
                    return;
                }
                let me=this;
                axios.put('/persona/actualizar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'dni': this.dni,
                    'email': this.email,
                    'celular': this.celular,
                    'grado_instruccion': this.grado_instruccion,
                    'ip': this.ip,
                    'imagen': this.imagen,
                    'empresa': this.empresa.split(' -')[0],
                    'id': this.persona_id,
                    'cli_id': this.cli_id
                }).then(function (response){
                    me.cerrarModal();
                    me.listarPersona(1,'','','','');
                })
                .catch(function (error){
                    console.log(error);
                });

                // axios.put(`https://api-atom.cicbla.com/api/cliente.php?id=${this.clid_id}`,{
                //     'cli_razon_social': this.empresa.split(' -')[0]
                // }).then(response => {
                //     console.log(response)
                // })
            },
            desactivarPersona(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to deactivate this person?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/persona/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarPersona(1,'','','','');
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
            activarPersona(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to activate this person?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/persona/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarPersona(1,'','','','');
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
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona=[];
                if (!this.nombre) this.errorMostrarMsjPersona.push("Person's name cannot be empty");
                if (!this.apellido) this.errorMostrarMsjPersona.push("The Person's last name cannot be empty");
                if (!this.dni) this.errorMostrarMsjPersona.push("The DNI of the Person cannot be empty");
                if (!this.email) this.errorMostrarMsjPersona.push("The Person's email cannot be empty");
                if (!this.celular) this.errorMostrarMsjPersona.push("The Person's cell phone cannot be empty");
                if (!this.grado_instruccion) this.errorMostrarMsjPersona.push("The degree instruction of the Person cannot be empty");



                if(this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
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
                this.cli_id = '';
            },
            abrirModal(modelo,accion, data=[]){
                switch(modelo){
                    case "persona":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Register Person';
                                        this.usuario_id = '';
                                        this.persona_id = '';
                                        this.nombre = '';
                                        this.apellido = '';
                                        this.empresa = '';
                                        this.dni = '';
                                        this.email = '';
                                        this.celular = '';
                                        this.imagen = '';
                                        this.imagenMiniatura = '';
                                        this.grado_instruccion = '';
                                        this.ip = '';
                                        this.tipoAccion=1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal=1;
                                        this.tituloModal="Update Person";
                                        this.tipoAccion=2;
                                        this.persona_id=data['id'];
                                        this.nombre = data['nombre'];
                                        this.apellido = data['apellido'];
                                        // this.empresa = data['empresa'];
                                        this.dni = data['dni'];
                                        this.email = data['email'];
                                        this.celular = data['celular'];
                                        this.grado_instruccion = data['grado_instruccion'];
                                        this.ip = data['ip'];
                                        this.imagen = '';
                                        this.imagenMiniatura = '';
                                        this.cli_id = data.cli_id;
                                        let nombre_empresa = this.empresas_all.filter(empresa => empresa.cli_id == data.cli_id)[0];
                                        this.empresa = `${nombre_empresa.cli_razon_social}`
                                        // this.empresa = `${nombre_empresa.cli_razon_social} - RUC: ${nombre_empresa.cli_nro_ruc}`

                                        break;

                                    }
                            }
                        }
                }
            },
            inputEmpresa(e){
                this.empresa = e.target.options[e.target.selectedIndex].text.split(' -')[0];
            }
        },
        mounted() {
            this.listarPersona(1,this.bnombre,this.bapellido,this.bdni,this.bempresa);
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
