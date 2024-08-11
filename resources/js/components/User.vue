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
                        <i class="fa fa-align-justify"></i> Users
                        <button type="button" @click="abrirModal('user','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;New
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">User Name: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bnombre" @keyup.enter="listarUser(1,bnombre,bapellido,bdni,bemail,buser)" class="form-control" placeholder="User Name" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">User Surname: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bapellido" @keyup.enter="listarUser(1,bnombre,bapellido,bdni,bemail,buser)" class="form-control" placeholder="User Surname" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Nº Document: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bdni" @keyup.enter="listarUser(1,bnombre,bapellido,bdni,bemail,buser)" class="form-control" placeholder="Nº Document"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Email: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bemail" @keyup.enter="listarUser(1,bnombre,bapellido,bdni,bemail,buser)" class="form-control" placeholder="Email"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">User: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="buser" @keyup.enter="listarUser(1,bnombre,bapellido,bdni,bemail,buser)" class="form-control" placeholder="User"></div>
                                    
                                    <button type="submit" @click="listarUser(1,bnombre,bapellido,bdni,bemail,buser)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div> 
                                </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Options</th>
                                    <th>Name</th>
                                    <th>Surname</th>
                                    <th>Document Type</th>
                                    <th>Nº Document</th>
                                    <th>Last Login</th>
                                    <th>Email</th>
                                    <th>Users</th>
                                    <th>Role</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="user in arrayUser" :key="user.id">
                                    <td>
                                        <button type="button" @click="abrirModal('user','actualizar',user)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <template v-if="user.estado">
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarUser(user.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarUser(user.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>
                                        
                                    </td>
                                    <td v-text="user.nombre"></td>
                                    <td v-text="user.apellido"></td>
                                    <td v-text="user.tipo_documento"></td>
                                    <td v-text="user.numero_documento"></td>
                                    <td v-text="fecha(user.updated_at)"></td>
                                    <td v-text="user.email"></td>
                                    <td v-text="user.usuario"></td>
                                    <td v-text="user.rol"></td>
                                    <td>
                                        <div v-if="user.estado">
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
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page-1,bnombre,bapellido,bdni,bemail,buser)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page==isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,bnombre,bapellido,bdni,bemail,buser)" v-text="page"></a>
                                </li>
                                
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,bnombre,bapellido,bdni,bemail,buser)">Sig</a>
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
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Name</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Enter Name">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Surname</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="apellido" class="form-control" placeholder="Enter Surname">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Document Type:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="tipo_documento" class="form-control" placeholder="Document Type">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nº Document</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="numero_documento" class="form-control" placeholder="Nº Document">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nº Cell phone</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="telefono" class="form-control" placeholder="# Cell phone">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">EMAIL</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="EMAIL">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Role (*)</label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="idrol">
                                            <option value="0">Select a Role</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Users</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Users">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="Write password">
                                    </div>
                                </div>
                                <div v-show="errorUser" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjUser" :key="error" v-text="error">

                                        </div>
                                    </div>

                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Close</button>
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrarUser()">Save</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarUser()">To update</button>
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
        data() {
            return{
            user_id: 0,
            idrol : 0,
            nombre : '',
            apellido : '',
            tipo_documento : 'DNI',
            numero_documento : '',
            telefono : '',
            email : '',
            ip : '',
            estado : '',
            usuario : '',
            password :'',
            arrayUser : [],
            arrayRol : [],
            //buscar
            bnombre:'',
            bapellido:'',
            bdni:'',
            bemail:'',
            buser:'',
            modal:0,
            tituloModal : '',
            tipoAccion:0,
            errorUser : 0,
            errorMostrarMsjUser : [],
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
            }
        },
        methods : {
            
            listarUser (page,bnombre,bapellido,bdni,bemail,buser) {
                let me=this;
                var url='/user?page=' + page + '&bnombre=' + bnombre + '&bapellido=' + bapellido
                 + '&bdni=' + bdni + '&bemail=' + bemail + '&buser=' + buser;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayUser = respuesta.users.data;
                    me.pagination = respuesta.pagination;
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            selectRol(){
                let me=this;
                var url='/rol/selectRol';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayRol = respuesta.roles;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            fecha (d){
                return moment(d).calendar();
            },
            cambiarPagina (page,bnombre,bapellido,bdni,bemail,buser){
                let me = this;
                //Actuializa la página actual
                me.pagination.current_page=page;
                me.listarUser(page,bnombre,bapellido,bdni,bemail,buser);

            },
            registrarUser(){
                if (this.validarUser()){
                    return;
                }
                let me=this;
                axios.post('/user/registrar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'idrol': this.idrol,
                    'tipo_documento': this.tipo_documento,
                    'numero_documento': this.numero_documento,
                    'telefono': this.telefono,
                    'email': this.email,
                    'usuario': this.usuario,
                    'password': this.password
                }).then(function (response){
                    me.cerrarModal();
                    me.listarUser(1,'','','','','');
                })
                .catch(function (error){
                    console.log(error);
                });
                
            },
            actualizarUser(){
                if (this.validarUser()){
                    return;
                }
                let me=this;
                axios.put('/user/actualizar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'idrol': this.idrol,
                    'tipo_documento': this.tipo_documento,
                    'numero_documento': this.numero_documento,
                    'telefono': this.telefono,
                    'email': this.email,
                    'usuario': this.usuario,
                    'password': this.password,
                    'id': this.user_id,
                }).then(function (response){
                    me.cerrarModal();
                    me.listarUser(1,'','','','','');
                })
                .catch(function (error){
                    console.log(error);
                });
            },
            desactivarUser(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Are you sure to deactivate this User?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/user/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarUser(1,'','','','','');
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
            activarUser(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'You are sure to activate this User',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'To accept',
                cancelButtonText: 'Cancel',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/user/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarUser(1,'','','','','');
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
            validarUser(){
                this.errorUser=0;
                this.errorMostrarMsjUser=[];
                if (!this.nombre) this.errorMostrarMsjUser.push("User name cannot be empty");
                if (!this.apellido) this.errorMostrarMsjUser.push("The User's last name cannot be empty");
                
                if (!this.email) this.errorMostrarMsjUser.push("The User's email cannot be empty");
                if (!this.telefono) this.errorMostrarMsjUser.push("User's phone cannot be empty");
                
                if (!this.usuario) this.errorMostrarMsjUser.push("User cannot be empty");

                if(this.errorMostrarMsjUser.length) this.errorUser = 1;

                return this.errorUser;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal = '';
                this.nombre = '';
                this.apellido = '';
                this.tipo_documento = 'DNI';
                this.numero_documento = '';
                this.telefono = '';
                this.email = '';
                this.usuario = '';
                this.idrol = 0;
                this.errorUser=0;
                
            },
            abrirModal(modelo,accion, data=[]){
                this.selectRol();
                switch(modelo){
                    case "user":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        this.modal = 1;
                                        this.tituloModal = 'Register User';
                                        this.usuario_id = '';
                                        this.nombre = '';
                                        this.apellido = '';
                                        this.tipo_documento = '';
                                        this.numero_documento = '';
                                        this.telefono = '';
                                        this.email = '';
                                        this.usuario = '';
                                        this.password = '';
                                        this.idrol = 0;
                                        this.tipoAccion=1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal=1;
                                        this.tituloModal="Update User";
                                        this.tipoAccion=2;
                                        this.user_id=data['id'];
                                        this.nombre = data['nombre'];
                                        this.apellido = data['apellido'];
                                        this.tipo_documento = data['tipo_documento'];
                                        this.numero_documento = data['numero_documento'];
                                        this.telefono = data['telefono'];
                                        this.email = data['email'];
                                        this.usuario = data['usuario'];
                                        this.password = data['password'];
                                        this.idrol = data['idrol'];
                                        break;
                                    }
                            }
                        }
                }
            }
        },
        mounted() {
            this.listarUser(1,this.bnombre,this.bapellido,this.bdni,this.bemail,this.buser);
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
