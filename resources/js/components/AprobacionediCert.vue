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
                        <i class="fa fa-align-justify"></i>EDIT CERTIFICATES APPROVAL
                    </div>
                    <template v-if="listado">
                    <!-- Listado -->
                     <div class="card-body">
                   <div class="form-group row">
                        <div class="col-md-11">
                            <div class="form-group row">
                     <label class="col-md-4 form-control-label" for="nombre">#Certificate: </label> 
                        <div class="col-md-5">
                                <input type="text" v-model="nombreS" @keyup.enter="listarAprobacion(1,nombreS,solicitante,aprobador)" class="form-control" placeholder="Name" ></div>
                    <label class="col-md-4 form-control-label" for="nombre">Applicant: </label> 
                        <div class="col-md-5">
                                <input type="text" v-model="solicitante" @keyup.enter="listarAprobacion(1,nombreS,solicitante,aprobador)" class="form-control" placeholder="Applicant" ></div>
                    <label class="col-md-4 form-control-label" for="solicitante">Approver: </label> 
                        <div class="col-md-5">
                                <input type="text" v-model="aprobador" @keyup.enter="listarAprobacion(1,nombreS,solicitante,aprobador)" class="form-control" placeholder="Approver"></div>
                                <button type="submit" @click="listarAprobacion(1,nombreS,solicitante,aprobador)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                       </div> 
                            </div>
                        </div>

                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Approved</th>
                                    <th># Certificate</th>
                                    <th>Solicitante</th>
                                    <th>Request Date</th>
                                    <th>Comentary</th>
                                    <th>Sent Client</th>
                                    <th>Approver</th>
                                    <th>Approved quantity</th>
                                    <th>Status</th>

                                </tr>
                            </thead>
                            <tbody>
                                
                                <tr v-for="aprobacion in arrayAprobacion" :key="aprobacion.id">
                                    <td><div v-if="aprobacion.condicion==0">
                                        </div>
                                        <div v-else-if="aprobacion.condicion==1">
                                        <button type="button" @click="Verdetalle('aprobacion','aprobacion',aprobacion)" class="btn btn-info btn-sm" >
                                          <i class="icon-eye"></i>
                                        </button> &nbsp; 
                                        </div>
                                        <div v-else-if="aprobacion.condicion==2 || aprobacion.condicion==3">
                                        </div>
                                        
                                    </td>
                                    <td v-text="aprobacion.certificado"></td>
                                    <td v-text="aprobacion.solicitante"></td>
                                    <td v-text="fecha(aprobacion.fecha_solicitud)"></td>
                                    <td v-text="aprobacion.comentario"></td>
                                    <td v-text="aprobacion.cliente"></td>
                                    <td>
                                        <div v-if="aprobacion.condicion==0">
                                            <label v-text="aprobacion.revisor"></label>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==1">
                                        Pending approval
                                        </div>
                                        <div v-else-if="aprobacion.condicion==2 || aprobacion.condicion==3">
                                            <label v-text="aprobacion.revisor"></label>
                                        </div>
                                        
                                    </td>
                                    <td>
                                        <div v-if="aprobacion.condicion==0">
                                            <label v-text="fecha(aprobacion.fecha_aprobacion)"></label>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==1">
                                        Pending approval
                                        </div>
                                        <div v-else-if="aprobacion.condicion==2 || aprobacion.condicion==3">
                                            <label v-text="fecha(aprobacion.fecha_aprobacion)"></label>
                                        </div>
                                    </td>
                                    <td><div v-if="aprobacion.condicion==0">
                                        <span class="badge badge-danger">Not approved</span>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==1">
                                        <span class="badge badge-success">Pending</span>
                                        </div>
                                        <div v-else-if="aprobacion.condicion==2 || aprobacion.condicion==3">
                                        <span class="badge badge-success">Approved</span>
                                        </div>
                                        
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table>
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,nombreS,solicitante,aprobador)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,nombreS,solicitante,aprobador)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,nombreS,solicitante,aprobador)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <template v-else>
                    <!-- Mostrar Datos -->
                    <div class="card-body">
                        <div class="form-group row border">
                            <h2 v-text="tituloModal"></h2>
                        </div>
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                        <div class="form-group row border">
                            <div class="col-md-12" style="font-size:20px"><h3><strong>Datos del Certificado Actual</strong></h3></div>
                            <div class="col-md-12">
                                
                                <table>
                                    <tr>
                                        <td width="450px"><h4># de Certificado:</h4> </td>
                                        <td><h4><label  v-text="'B - 23.00 '+certificado"></label></h4> </td>
                                    </tr>
                                    <tr>
                                        <td><h4>Participante/N° Documento:</h4> </td>
                                        <td><h4 v-text="persona+' / '+num_dni"></h4> </td>
                                    </tr>
                                    <tr>
                                        <td><h4>Empresa / PDSI:</h4></td>
                                        <td ><h4 v-text="empresa+' / '+pdsi "> </h4></td>
                                    </tr>
                                    <tr>
                                        <td><h4>Designación / Equipos:</h4> </td>
                                        <td ><h4 v-text="designacion_en+' OPERATOR: '+equipos_en "></h4> </td>
                                    </tr>
                                    <tr>
                                        <td><h4>Fecha de Emisión:</h4> </td>
                                        <td ><h4 v-text="fecha_emision7"></h4> </td>
                                    </tr>
                                    
                                </table><br>
                                </div>
                                    <div class="col-md-12" for="text-input"><h3><strong>Cambios solicitados a Realizar:</strong></h3><br></div>
                            <div class="col-md-12">
                                        <table style="font-size:15px;font-weight: bold;">
                                            <tr>
                                                <td width="450px"><h4>Nombres / Empresa del Participante</h4></td>
                                                <td><template v-if="nombre_edi=='true'">
                                                    <input checked="checked" style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    <template v-else>
                                                    <input style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><h4>Designación del Certificado</h4></td>
                                                <td><template v-if="designacion_edi=='true'">
                                                    <input checked="checked" style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    <template v-else>
                                                    <input style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td><h4>Fechas/Normativas/Horas</h4></td>
                                                <td><template v-if="normativa_edi=='true'">
                                                    <input checked="checked" style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    <template v-else>
                                                    <input style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td><h4>Firma</h4></td>
                                                <td><template v-if="firma_edi1=='true'">
                                                    <input checked="checked" style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    <template v-else>
                                                    <input style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td><h4>Foto del Participante(Carné)</h4></td>
                                                <td><template v-if="foto_edi=='true'">
                                                    <input checked="checked" style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    <template v-else>
                                                    <input style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    </td>
                                            </tr>
                                            <tr>
                                                <td><h4>Anulación de Certificado/Carné</h4></td>
                                                <td><template v-if="anulacion_edi=='true'">
                                                    <input checked="checked" style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template>
                                                    <template v-else>
                                                    <input style="width:25px;height:25px;" type="checkbox" disabled>
                                                    </template></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-3 form-control-label" for="text-input"><br><h4>Cambios Propuesto:</h4> </div>
                                    <div class="col-md-9"><br>
                                        <textarea  v-model="comentario" class="form-control" width="100%" readonly></textarea>
                                                                            
                                    </div>
                            
                            
                        
                        </div>
                        </form>   
                        <div class="form-group row">
                            <button type="button" class="btn btn-danger" @click="Desaprobar()">Disapprove</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="Aprobar()">Approve</button>&nbsp;&nbsp;
                            <button type="button" class="btn btn-secondary" @click="MirarResumen()">Cancel</button>
                        </div>             
                    </div>
                    </template>
                <!-- Fin ejemplo de tabla Listado -->
            </div></div>
            <!--Inicio del modal agregar/actualizar-->
            <div class="modal fade"  tabindex="-1" :class="{'mostrar': modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal1()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form @submit.prevent="formEdicion" method="post" enctype="multipart/form-data" class="form-horizontal">
                            
                                <div class="form-group row">
                                    <label class="col-md-12 form-control-label" for="text-input" style="font-size:20px"><strong>Datos del Certificado</strong></label>
                                    <label class="col-md-3 form-control-label" for="text-input"># de Certificado:</label> <label class="col-md-9 form-control-label" v-text="'B - 23.00 '+certificado"></label>
                                    <label class="col-md-3 form-control-label" for="text-input">Participante/N° Documento:</label> <label class="col-md-9 form-control-label" v-text="persona+' / '+num_dni"></label>
                                    <label class="col-md-3 form-control-label" for="text-input">Empresa:</label> <label class="col-md-9 form-control-label" v-text="empresa"></label>
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha de Emisión:</label> <label class="col-md-9 form-control-label" v-text="fecha_emision7"></label>
                                    
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Marque los cambios a Realizar:</label>
                                    <div class="col-md-9">
                                        <table style="font-size:15px;font-weight: bold;">
                                            <tr>
                                                <td>Nombres / Empresa del Participante</td>
                                                <td><input v-model="nombre_edi" type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Designación del Certificado</td>
                                                <td><input v-model="designacion_edi"  type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Fechas/Normativas/Horas</td>
                                                <td><input v-model="normativa_edi"  type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Firma</td>
                                                <td><input v-model="firma_edi1"  type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Foto del Participante(Carné)</td>
                                                <td><input v-model="foto_edi"  type="checkbox"></td>
                                            </tr>
                                            <tr>
                                                <td>Anulación de Certificado/Carné</td>
                                                <td><input v-model="anulacion_edi"  type="checkbox"></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Certificado Enviado al Cliente:</label>
                                    <div class="col-md-9">
                                        <input v-model="cliente" type="radio" value="Si">
                                        <label for="contactChoice1">Si</label>

                                        <input v-model="cliente" type="radio" value="No">
                                        <label for="contactChoice2">No</label>
                                                                            
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Ingresar Sustento:</label>
                                    <div class="col-md-9">
                                        <textarea  v-model="comentario" class="form-control"></textarea>
                                                                            
                                    </div>
                                </div>
                                
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" @click="cerrarModal1()">Close</button>
                                <button v-if="tipoAccion==1" class="btn btn-primary">Solicitar</button>
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
import moment from 'moment'
    export default {
        data(){
            return{
                //Datos Listado de Edicion
                id:'',
                certificado:'',
                solicitante:'',
                fecha_solicitud:'',
                condicion:'',
                comentario:'',
                cliente:'',
                revisor:'',
                fecha_aprobacion:'',
                //Campos para la Edicion de Certificados con Autorización
                nombre_edi:'',
                designacion_edi:'',
                normativa_edi:'',
                firma_edi1:'',
                foto_edi:'',
                anulacion_edi:'',
                cliente:'',
                comentario:'',
                persona:'',
                num_dni:'',
                empresa:'',
                fecha_emision7:'',
                designacion_en:'',
                equipos_en:'',
                pdsi:'',
                //Datos del Listado
                aprobacion_id: 0,
                solicitud_id: 0,
                nombre: '',
                nusuario: '',
                apellido: '',
                created_at: '',
                stock_actual: '',
                cantidad: '',
                ultima_solicitud: '',
                comentario: '',
                usuario_id: 0,
                cantidad_aprob: '',
                arrayAprobacion: [],
                arraySolicitante:[],
                //
                modal : 0,
                tituloModal:'',
                tipoAccion : 0 ,
                errorAprobacion : 0,
                errorMostrarMsjAprobacion : [],
                listado: 1,
                pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
                },
                offset : 3,
                nombreS : '',
               
                aprobador :'',
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
           listarAprobacion (page,nombreS,solicitante,aprobador){
                let me=this;
                var url= '/edicioncerti2?page=' + page + '&nombreS='+ nombreS+ '&solicitante='+ solicitante+ '&aprobador=' +aprobador;
                axios.get(url).then(function (response) {
                    console.log(response.data);
                    var respuesta= response.data;
                    me.arrayAprobacion = respuesta.aprobaciones.data;
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
            cambiarPagina(page,nombreS,solicitante,aprobador){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para visualizar la data de esa pagina 
                me.listarAprobacion(page,nombreS,solicitante,aprobador);
            },
            Desaprobar(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de desaprobar la solicitud de edición de Certificado/Carne?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Desaprobado',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.post('/edicion/desaprobar',
                                    {
                                        'id': this.id
                                        }).then(function (response) {
                                    me.listarAprobacion(1,'','','');
                                    
                        swalWithBootstrapButtons.fire(
                        'Desaprobado',
                        'Solicitud Desaprobada',
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
                        'cancelled',
                        'Lot Request Disapproval was canceled',
                        'error'
                        )
                    }
                    })
                    this.listado=1;
            },
            MirarResumen(){
                this.listado=1;
            },
            Aprobar(){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: '¿Estás seguro de aprobar la solicitud de edición de Certificado/Carne?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Aprobado',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.post('/edicion/aprobar',
                                    {
                                        'id': this.id
                                        }).then(function (response) {
                                    me.listarAprobacion(1,'','','');
                        swalWithBootstrapButtons.fire(
                        'Aprobado',
                        'Solicitud Aprobada',
                        'Success'
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
                        'Approval was Canceled',
                        'error'
                        )
                    }
                    })
                    this.listado=1;
            },
            validarAprobacion(){
                    this.errorAprobacion=0;
                    this.errorMostrarMsjAprobacion =[];

                    if(!this.cantidad) this.errorMostrarMsjAprobacion.push("Quantity cannot be empty.");
                    if(this.errorMostrarMsjAprobacion.length) this.errorAprobacion = 1;
                    return this.errorAprobacion;
           },
            
            Verdetalle(modelo, accion, data = []){
                this.listado=0;
                switch(modelo){
                    case "aprobacion":
                        {
                            switch(accion){
                                case 'aprobacion':
                                {
                                    this.tituloModal = 'Aprobación de Solicitud de Edición de Certificados';
                                    this.tipoAccion= 2;
                                    this.id= data['id'];
                                    this.nombre_edi= data['nombre_empresa'];
                                    this.designacion_edi= data['designacion'];
                                    this.normativa_edi= data['otros'];
                                    this.firma_edi1= data['firma'];
                                    this.foto_edi= data['foto'];
                                    this.anulacion_edi= data['anulacion'];
                                    this.cliente= data['cliente'];
                                    this.comentario= data['comentario'];
                                    this.persona= data['persona'];
                                    this.num_dni= data['dni'];
                                    this.empresa= data['empresa'];
                                    this.fecha_emision7= data['fecha_emision7'];
                                    this.certificado = data['certificado'];
                                    this.pdsi=data['pdsi'];
                                    this.designacion_en=data['designacion_en'],
                                    this.equipos_en=data['equipos_en'],
                                    this.usuario_id= '';
                                    this.cantidad_aprob= '';
                                    break;
                                }
                            }
                        }
                }
            }
        },
            
        mounted() {
           this.listarAprobacion(1,this.nombreS,this.solicitante,this.aprobador);
        }
    }
</script>
<style>
    
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }

</style>