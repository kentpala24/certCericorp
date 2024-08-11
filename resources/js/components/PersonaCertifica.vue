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
                    <template v-if="listado==1">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> EMPRESA
                        <button type="button" @click="modalesCliente('cliente','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                    </div>
                    
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">Cliente: </label>
                            <div class="col-md-5">
                                <input type="text" v-model="bcliente" @keyup.enter="listarCliente(1,bcliente,bruc,bcodigo,binicialesv)" class="form-control" placeholder="Cliente" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">RUC: </label>
                            <div class="col-md-5">
                                <input type="text" v-model="bruc" @keyup.enter="listarCliente(1,bcliente,bruc,bcodigo,binicialesv)" class="form-control" placeholder="RUC" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Codigo: </label>
                            <div class="col-md-5">
                                    <input type="text" v-model="bcodigo" @keyup.enter="listarCliente(1,bcliente,bruc,bcodigo,binicialesv)" class="form-control" placeholder="Codigo"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Inciales: </label>
                            <div class="col-md-5">
                                    <input type="text" v-model="binicialesv" @keyup.enter="listarCliente(1,bcliente,bruc,bcodigo,binicialesv)" class="form-control" placeholder="Inciales"></div>
                                    <button type="submit" @click="listarCliente(1,bcliente,bruc,bcodigo,binicialesv)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                                </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Cliente</th>
                                    <th>RUC</th>
                                    <th>Codigo</th>
                                    <th>Iniciales</th>
                                    <th>Estado </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="cliente in arrayCliente" :key="cliente.id">
                                    <td><template v-if="cliente.condicion">
                                        <button type="button" @click="modalesCliente('cliente','actualizar',cliente)" class="btn btn-warning btn-sm">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <button type="button" @click="modalesCliente('cliente','ver',cliente)" class="btn btn-warning btn-sm" >
                                            <i class="icon-eye"></i>
                                        </button> &nbsp;
                                        
                                            <button type="button" class="btn btn-danger btn-sm" @click="desactivarCliente(cliente.id)">
                                            <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm" @click="activarCliente(cliente.id)">
                                            <i class="icon-check"></i>
                                            </button>
                                        </template>

                                    </td>
                                    <td v-text="cliente.cliente"></td>
                                    <td v-text="cliente.ruc_cliente"></td>
                                    <td v-text="cliente.codigo_cliente"></td>
                                    <td v-text="cliente.iniciales_cliente"></td>
                                    <td>
                                        <div v-if="cliente.condicion">
                                            <span class="badge badge-success">Activado</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
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
                </template>
                <template v-if="listado==2">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> PROFESIONAL
                        <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Nuevo
                        </button>
                        <button type="button" @click="abrirModal('persona','regreso')" class="btn btn-secondary">
                            <i class="icon-back"></i>&nbsp;Atras
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">Nombre: </label>
                            <div class="col-md-5">
                                <input type="text" v-model="bnombre" @keyup.enter="listarPersona(1,bnombre,bapellido,bdni,idCliente)" class="form-control" placeholder="Name" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">Apellido: </label>
                            <div class="col-md-5">
                                <input type="text" v-model="bapellido" @keyup.enter="listarPersona(1,bnombre,bapellido,bdni,idCliente)" class="form-control" placeholder="Surname" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Nº Document: </label>
                            <div class="col-md-5">
                                    <input type="text" v-model="bdni" @keyup.enter="listarPersona(1,bnombre,bapellido,bdni,idCliente)" class="form-control" placeholder="Nº Document"></div>
                            
                            <div class="col-md-5">
                                    <input type="hidden" v-model="idCliente" @keyup.enter="listarPersona(1,bnombre,bapellido,bdni,idCliente)" class="form-control" placeholder="Company"></div>
                                    <button type="submit" @click="listarPersona(1,bnombre,bapellido,bdni,idCliente)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div>
                                </div>
                        </div>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Opciones</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>N°Documento</th>
                                    <th>Correo</th>
                                    <th>Usuario</th>
                                    <th>Foto</th>
                                    <th>Estado </th>
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
                                    <td v-text="persona.usuario"></td>
                                    <td>
                                        <figure>
                                        <img width="50" height="50" :src="'/storage/'+persona.imagen"  name="perfil">
                                        </figure>
                                    </td>
                                    <td>
                                        <div v-if="persona.condicion">
                                            <span class="badge badge-success">Activado</span>
                                        </div>
                                        <div v-else>
                                            <span class="badge badge-danger">Desactivado</span>
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
                </template>
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
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Enter Names">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Apellido</label>
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
                                    <label class="col-md-3 form-control-label" for="text-input">N°Documento:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="dni" class="form-control" placeholder="DNI">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Correo</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Celular </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="celular" class="form-control" placeholder="# Number license">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Foto</label>
                                    <div class="col-md-9">
                                        <input type="file" @change="obtenerImagen" name="perfil" class="form-control" placeholder="Upload Image">
                                    </div>
                                    <label class="col-md-3 form-control-label" for="text-input"></label>

                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Activar Usuario Web </label>
                                    <div class="col-md-9">
                                        <select class="form-control" v-model="indiUsua">
                                            <option value="1">NO</option>
                                            <option value="2">SI</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Usuario </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" :disabled="indiUsua==1" class="form-control" placeholder="Usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Contraseña </label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="password" class="form-control" placeholder="Contraseña">
                                    </div>
                                </div>
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal()">Cerrar</button>
                            <button v-if="tipoAccion==1" class="btn btn-primary">Guardar</button>
                            <button v-if="tipoAccion==2" class="btn btn-primary">Actualizar</button>
                        </div>
                            </form>
                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
                       <!--Inicio del modal agregar/actualizar-->
                       <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal2}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal2()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                           
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Cliente</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="cliente" class="form-control" placeholder="Cliente">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ruc</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="rucCliente" class="form-control" placeholder="RUC">
                                    </div>
                                </div>
                                <!-- <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Current company</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="empresa" class="form-control" placeholder="Enter current company">
                                    </div>
                                </div> -->
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Codigo:</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="codigoCliente" class="form-control" placeholder="Codigo">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Iniciales</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="inicialesCliente" class="form-control" placeholder="Iniciales">
                                    </div>
                                </div>
                                
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>

                                </div>
                                <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" @click="cerrarModal2()">Cerrar</button>
                            <button v-if="tipoAccion==1" class="btn btn-primary" @click="registrarCliente()">Guardar</button>
                            <button v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarCliente()">Actualizar</button>
                        </div>
                            
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
            listado: 1,
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
            indiUsua:'',
            password:'',
            usuario:'',
            arrayPersona : [],
            arrayCliente : [],
            //buscador
            bnombre:'',
            bapellido:'',
            bdni:'',
            bempresa:'',
            //BuscarCliente
            bcliente:'',
            bruc:'',
            bcodigo:'',
            binicialesv:'',
            //Registro y Actualizacion Cliente
            idCliente:0,
            cliente:'',
            rucCliente:'',
            codigoCliente:'',
            inicialesCliente:'',

            ////////////////////////
            modal:0,
            modal2:0,
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
            listarCliente (page,bcliente,bruc,bcodigo,binicialesv) {
                let me=this;
                var url='/cliente?page=' + page + '&nombre=' + bcliente + '&ruc=' + bruc
                + '&codigo=' + bcodigo + '&iniciales=' + binicialesv;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayCliente = respuesta.cliente.data;
                    me.pagination = respuesta.pagination;
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
            listarPersona (page,bnombre,bapellido,bdni,idCliente) {
                let me=this;
                var url='/personaC?page=' + page + '&bnombre=' + bnombre + '&bapellido=' + bapellido
                + '&bdni=' + bdni + '&bempresa=' + idCliente;
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination = respuesta.pagination;
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

            cambiarPagina(page,bnombre,bapellido,bdni,idCliente){
                let me = this;
                //Actuializa la página actual
                me.pagination.current_page=page;
                me.listarPersona(page,bnombre,bapellido,bdni,idCliente);

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
                formData.set('indiUsua', this.indiUsua)
                formData.set('usuario', this.usuario)
                formData.set('password', this.password)
                if(this.persona_id==''){
                    axios.post('/personaC/registrar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarPersona(1,'','','',me.idCliente);
                })
                .catch(function (error){
                    console.log(error);
                });
                }
                else{
                    axios.post('/personaC/actualizar',formData).then(function (response){
                    me.cerrarModal();
                    me.listarPersona(1,'','','',me.idCliente);
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
                let idC=this.cli_id;
                axios.post('/personaC/registrar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'dni': this.dni,
                    'email': this.email,
                    'celular': this.celular,
                    'grado_instruccion': this.grado_instruccion,
                    'ip': this.ip,
                    'imagen': this.imagen,
                    'empresa': this.cli_id,
                    'cli_id': this.cli_id

                }).then(function (response){
                    console.log(idC);
                    me.idCliente = idC;
                    me.cli_id = idC;
                    me.cerrarModal();
                    me.listarPersona(1,'','','',me.idCliente);
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
                axios.put('/personaC/actualizar',{
                    'nombre': this.nombre,
                    'apellido': this.apellido,
                    'dni': this.dni,
                    'email': this.email,
                    'celular': this.celular,
                    'grado_instruccion': this.grado_instruccion,
                    'ip': this.ip,
                    'imagen': this.imagen,
                    'empresa': this.idCliente,
                    'id': this.persona_id,
                    'cli_id': this.cli_id
                }).then(function (response){
                    me.cerrarModal();
                    me.listarPersona(1,'','','',me.idCliente);
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
                    axios.put('/personaC/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarPersona(1,'','','',this.idCliente);
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
                    axios.put('/personaC/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarPersona(1,'','','',this.idCliente);
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
            
            registrarCliente(){
                if (this.validarCliente()){
                    return;
                }
                let me=this;
                axios.post('/cliente/registrar',{
                    'cliente': this.cliente,
                    'ruc': this.rucCliente,
                    'codigo': this.codigoCliente,
                    'iniciales': this.inicialesCliente

                }).then(function (response){
                    me.cerrarModal2();
                    me.listarCliente(1,'','','','');
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            actualizarCliente(){
                if (this.validarCliente()){
                    return;
                }
                let me=this;
                axios.post('/cliente/actualizar',{
                    'cliente': this.cliente,
                    'ruc': this.rucCliente,
                    'codigo': this.codigoCliente,
                    'iniciales': this.inicialesCliente,
                    'id': this.idCliente
                }).then(function (response){
                    me.cerrarModal2();
                    me.listarCliente(1,'','','','');
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
            desactivarCliente(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quieres desactivar este Cliente?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/cliente/desactivar',{
                    'id': id
                    }).then(function (response){
                    me.listarCliente(1,'','','','');
                     swalWithBootstrapButtons.fire(
                    'Desabilitado',
                    'Cliente Desactivado.',
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
            activarCliente(id){
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Quieres Activar al Cliente',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me=this;
                    axios.put('/cliente/activar',{
                    'id': id
                    }).then(function (response){
                    me.listarCliente(1,'','','','');
                     swalWithBootstrapButtons.fire(
                    'Activated',
                    'Cliente Activado.',
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
            validarCliente(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona=[];
                if (!this.cliente) this.errorMostrarMsjPersona.push("Campo cliente no puede ser vacio");
                if (!this.rucCliente) this.errorMostrarMsjPersona.push("El campo ruc no puede ser Vacío");
               
                



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
                this.indiUsua = '';
                this.usuario = '';
                this.password = '';
               // this.cli_id = '';
            },
            cerrarModal2(){
                this.modal2=0;
                this.tituloModal = '';
                this.cliente = '';
                this.ruc = '';
                this.codigoCliente = '';
                this.inicialesCliente = '';
                
            },
            abrirModal(modelo,accion, data=[]){
                switch(modelo){
                    case "persona":
                        {
                            switch(accion){
                                case 'registrar':
                                    {
                                        //this.cerrarModal2();
                                        this.modal = 1;
                                        this.tituloModal = 'Registrar Persona';
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
                                        this.indiUsua = '';
                                        this.usuario = '';
                                        this.password = '';
                                        this.indiUsua = 1;  
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal=1;
                                        this.tituloModal="Actualizar Persona";
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
                                        this.usuario = data['usuario'];  
                                        if(data['usuario']){
                                            this.indiUsua = 2;  
                                        }  
                                        else{
                                            this.indiUsua = 1;  
                                        }
                                        this.empresa = `${nombre_empresa.cli_razon_social}`
                                        // this.empresa = `${nombre_empresa.cli_razon_social} - RUC: ${nombre_empresa.cli_nro_ruc}`

                                        break;

                                    }
                                    case 'regreso':
                                    {
                                        this.listado = 1;
                                        break;

                                    }
                            }
                        }
                    
                }
            },
            modalesCliente(modelo,accion, data=[]){
                switch(modelo){
                    
                    case('cliente'):
                    {
                        switch(accion){
                                case 'registrar':
                                    {   if(this.listado == 1){
                                        this.modal2 = 1;
                                        this.tituloModal = 'Registrar Cliente';
                                    }
                                        this.cliente='';
                                        this.rucCliente='';
                                        this.codigoCliente='';
                                        this.inicialesCliente='';
                                        this.tipoAccion=1;
                                        break;
                                    }
                                case 'actualizar':
                                    {
                                        this.modal2=1;
                                        this.tituloModal="Actualizar Cliente";
                                        this.tipoAccion=2;
                                        this.idCliente=data['id'];
                                        this.cliente = data['cliente'];
                                        this.rucCliente = data['ruc_cliente'];
                                        this.codigoCliente = data['codigo_cliente'];
                                        this.inicialesCliente = data['iniciales_cliente'];
                                        break;

                                    }
                                    case 'ver':
                                    {
                                        this.idCliente = data['id'];
                                        this.cli_id = data['id'];
                                        this.listado = 2;
                                        this.listarPersona(1,'','','',this.idCliente);
                                        break;

                                    }
                            }
                    }
                }
            },
        },
        mounted() {
            this.listarCliente(1,this.bcliente,this.bruc,this.bcodigo,this.binicialesv);
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
