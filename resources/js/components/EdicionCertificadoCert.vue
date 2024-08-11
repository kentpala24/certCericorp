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
                        <i class="fa fa-align-justify"></i> DIGITAL CERTIFICATES
                        <button type="button" @click="Verdetalle('certificado','registrar')" class="btn btn-secondary">
                            <i class="icon-plus"></i>&nbsp;Generate Certificates
                        </button>
                        
                    </div>
            <template v-if="listado==1">
                    <div class="card-body">
                        <div class="form-group row">
                            <div class="col-md-11">
                            <div class="form-group row">
                            <label class="col-md-4 form-control-label" for="nombre">PDSI: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bpdsi" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="PDSI" ></div>
                            <label class="col-md-4 form-control-label" for="nombre">Company: </label> 
                            <div class="col-md-5">
                                <input type="text" v-model="bempresa" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Company" ></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Nº Certificate: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bnumero" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Nº Certificate"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Name Professional: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bnpersona" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Name Professional"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Surname Professional: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="bapersona" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Surname Professional"></div>
                            <label class="col-md-4 form-control-label" for="solicitante">Certificate type: </label> 
                            <div class="col-md-5">
                                    <input type="text" v-model="btipo_certificado" @keyup.enter="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="form-control" placeholder="Certificate type"></div>
                                    <button type="submit" @click="listarCertificado(1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" class="btn btn-primary"><i class="fa fa-search"></i> Search</button>
                            </div> 
                                </div>
                        </div>
                        <strong>Leyenda:</strong> <br>
                        <button class="btn btn-info btn-sm" >
                            Ver Certificado<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                            </svg>
                        </button> 
                        <button type="button" class="btn btn-success btn-sm">
                            Ver Carné Emitdo<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-heading" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                <path fill-rule="evenodd" d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                                <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z"/>
                            </svg>
                        </button>
                        <button type="button" class="btn btn-warning btn-sm">
                                Ver Carné Revalidado<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-checklist" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                    <path fill-rule="evenodd" d="M7 5.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 1 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0zM7 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm-1.496-.854a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0l-.5-.5a.5.5 0 0 1 .708-.708l.146.147 1.146-1.147a.5.5 0 0 1 .708 0z"/>
                                </svg>
                        </button>
                        <table class="table table-bordered table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Certificate</th>
                                    <th>Card</th>
                                    <th>PDSI / Batch Nº</th>
                                    <th>Nº Certificate</th>
                                    <th>Name / Surname</th>
                                    <th>Certificate type </th>
                                    <th>Level</th>
                                    <th>Issue date</th>
                                    <th>Expiration date</th>
                                    <th>Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr v-for="certificado in arrayCertificado" :key="certificado.id">
                                        <td><template v-if="certificado.edicions_condicion==2 || certificado.edicions_condicion==7">
                                            <button type="button" @click="Verdetalle('certificado','actualizar',certificado)" class="btn btn-success btn-sm" >
                                            <i class="icon-eye"></i>
                                            </button> 
                                        </template>
                                        <template v-if="certificado.edicions_condicion==3 || certificado.edicions_condicion==4 || certificado.edicions_condicion==5">
                                            <button type="button" @click="cargarPdfemision(certificado.id)" class="btn btn-info btn-sm" >
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-check" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                                            </svg>
                                            </button> 
                                            
                                        </template>
                                        <template v-if="certificado.edicions_condicion==5">
                                        </template>
                                            
                                    </td>
                                     
                                    <td>
                                        <template v-if="certificado.edicions_condicion==3 || certificado.edicions_condicion==5">
                                            <button type="button" class="btn btn-info btn-sm" @click="Vercarne('certificado','actualizar',certificado)">
                                                <i class="icon-eye"></i>
                                            </button>
                                        </template>
                                        <template v-else-if="certificado.edicions_condicion==4">
                                            <button type="button" class="btn btn-success btn-sm" @click="cargarCarnePdfemision(certificado.idcarne)">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-card-heading" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M14.5 3h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-13z"/>
                                                    <path fill-rule="evenodd" d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5z"/>
                                                    <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5v-1z"/>
                                                </svg>
                                            </button>
                                        </template>
                                        <template v-else-if="certificado.edicions_condicion==6">
                                        </template>
                                    </td>

                                    <td v-html="certificado.pdsi+'<br>'+certificado.numero"></td>
                                    <div v-if="certificado.certificado==0">
                                        <td>Without Issuing</td>
                                    </div>
                                    <div v-else>
                                        <td v-text="'B - 23.00'+certificado.certificado"></td>
                                    </div>

                                    <td v-text="certificado.nombre+' '+certificado.apellido"></td>
                                    <td v-text="certificado.designacion+' '+certificado.tipo_certificados"></td>
                                    <td v-text="certificado.level"></td>
                                    <td v-text="certificado.fecha_emision7"></td>
                                    <td v-text="certificado.fecha_expiracion"></td>
                                    <td> <div v-if="certificado.condicion==1">
                                        <span class="badge badge-secondary">To be issued</span>
                                        </div>
                                        <div v-else-if="certificado.fecha_expiracion<fechahoy()">
                                        <span class="badge badge-danger">Expired</span>
                                        </div>
                                        <div v-else-if="certificado.condicion==0">
                                        <span class="badge badge-secondary">Canceled</span>
                                        </div>
                                        <div v-else-if="certificado.condicion==2">
                                        <span class="badge badge-success">Issued</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        
                        <nav>
                            <ul class="pagination">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)">Ant</a>
                                </li>
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active': '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)" v-text="page"></a>
                                </li>
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page+1,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
            </template>
            <template v-else-if="listado==0">
                    
                            <!-- Mostrar Datos -->
                    <div class="card-body">
                        <div class="form-group row border">
                            <h2 v-text="tituloModal"></h2>
                        </div>
                        <div class="form-group row border">
                            <template v-if="nombre_edi=='true'">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Professional <label v-text="nombre_edi"></label><span style="color:red;" v-show="persona_id==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        <input type="text" class="form-control" v-model="dni" @keyup.enter="buscarPersona()" placeholder="Enter personnel ID ">
                                        <button @click="buscarPersona()" class="btn btn-primary">...</button>
                                        <input type="hidden" v-model="persona_id" class="form-control">
                                    </div>
                                </div>  
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Professional:</label>
                                    <select class="form-control" v-model="persona_id">
                                            <option value="0">Select a Professional</option>
                                            <option v-for="personas in arrayPersona1" :key="personas.id" :value="personas.id" v-text="personas.nombre+' '+personas.apellido"></option>
                                        </select>
                                </div>  
                            </div>
                            <div class="col-md-5"> 
                                <div class="form-group">
                                    <label>Company:</label>
                                    <input type="text" v-model="empresa" class="form-control">
                                </div>  
                            </div>
                            </template>
                            <template v-if="designacion_edi=='true'">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Certificate type :</label>
                                    <select class="form-control" v-model="tipo_certificado_id">
                                            <option value="0">Select a</option>
                                            <option v-for="tipo in arrayTipo_certificado" v-bind:key="tipo.id" :value="tipo.id" v-text="tipo.nombre"></option>
                                    </select>
                                <template v-if="tipo_certificado_id==13">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionOperador" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>
                                <template v-if="tipo_certificado_id==14">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionRigger" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>

                                <template v-if="tipo_certificado_id==17">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionSupervisor" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>

                                <template v-if="tipo_certificado_id==14">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arrayDesignacionOtros" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>
                                <template v-if="tipo_certificado_id==15">
                                    <select class="form-control" v-model="iddesignacion">
                                            <option value="0">Select a Designacion</option>
                                            <option v-for="designacion in arraySenalero" v-bind:key="designacion.id" :value="designacion.id" v-text="designacion.designacion_ingles"></option>
                                    </select>
                                </template>
                                    

                                    
                                </div>  
                            </div>
                            <div class="col-md-6">
                                    <div class="form-group">
                                    <label>Equipment:</label>
                                    
                                    <select class="form-control" v-model="cond_equipo">
                                            <option value="0">Do not include equipment</option>
                                            <option value="1">Include Equipment</option>
                                            <option value="2">Include Truck, Yellow Line, White Line</option>
                                    </select>
                                    <template v-if="cond_equipo==1">
                                        <textarea v-model="equipo" cols="80" rows="5" class="form-control"></textarea>
                                    </template>
                                    <template v-if="cond_equipo==2">
                                        EN: <textarea v-model="equipo" cols="75" rows="2" class="form-control"></textarea>
                                        ES: <textarea v-model="equipoes" cols="75" rows="2" class="form-control"></textarea>
                                    </template>
                                    </div>
                            </div>
                            </template>
                            <template v-if="normativa_edi=='true'">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Level:</label>
                                    <select class="form-control" v-model="level">
                                        <option value="Basic Level">Basic Level</option>
                                        <option value="Intermediate Level">Intermediate Level</option>
                                        <option value="Level 1">Level 1 - 1 year</option>
                                        <option value="Level I">Level 1 - 2 year</option>
                                    </select>
                                </div> 
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Normative English:<button @click="buscarDesignacion()" class="btn btn-primary">...</button></label>
                                    <input type="text" v-model="normativa" class="form-control">
                                    <label>Normative Spanish:</label>
                                    <input type="text" v-model="normativaes" class="form-control">
                                </div> 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Training Days:</label>
                                    <div class="form-inline">
                                    <select class="form-control" v-model="dias">
                                            <option value="1">1 Day</option>
                                            <option value="2">2 Days</option>
                                            <option value="3">3 Days</option>
                                            <option value="4">4 Days</option>
                                            <option value="5">5 Days</option>
                                            <option value="6">6 Days</option>
                                            <option value="7">7 Days</option>
                                    </select><br/>
                                                          
                                    </div>
                                    <template v-if="dias==1">
                                        <label>Select evaluation days</label>
                                        <div class="form-inline">
                                            <label>Day 1:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision7" class="form-control">
                                        </div>
                                    </template>
                                    <template v-if="dias==2">
                                        <label>Select evaluation days</label>
                                        <div class="form-inline">
                                            <label>Day 1:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 2:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision7" class="form-control">
                                        </div>
                                    </template>
                                    <template v-if="dias==3">
                                        <label>Select evaluation days</label>
                                        <div class="form-inline">
                                            <label>Day 1:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 2:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision2" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 3:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision7" class="form-control">
                                        </div>
                                    </template>
                                    <template v-if="dias==4">
                                        <label>Select evaluation days</label>
                                        <div class="form-inline">
                                            <label>Day 1:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 2:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision2" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 3:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision3" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 4:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision7" class="form-control">
                                        </div>
                                    </template>
                                    <template v-if="dias==5">
                                        <label>Select evaluation days</label>
                                        <div class="form-inline">
                                            <label>Day 1:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 2:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision2" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 3:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision3" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 4:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision4" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 5:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision7" class="form-control">
                                        </div>
                                    </template>
                                    <template v-if="dias==6">
                                        <label>Select evaluation days</label>
                                        <div class="form-inline">
                                            <label>Day 1:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 2:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision2" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 3:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision3" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 4:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision4" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 5:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision5" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 6:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision7" class="form-control">
                                        </div>
                                    </template>
                                    <template v-if="dias==7">
                                        <label>Select evaluation days</label>
                                        <div class="form-inline">
                                            <label>Day 1:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 2:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision2" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 3:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision3" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 4:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision4" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 5:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision5" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 6:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision6" class="form-control">
                                        </div>
                                        <div class="form-inline">
                                            <label>Day 7:</label>&nbsp;&nbsp;&nbsp;&nbsp;
                                            <input type="date" v-model="fecha_emision7" class="form-control">
                                        </div>
                                    </template>
                                    
                                </div> 
                            </div>
                            </template>
                            <template v-if="firma_edi=='true'">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Signature:</label>
                                    <select class="form-control" v-model="firma_id">
                                            <option value="0">Select a signature</option>
                                            <option v-for="firma in arrayFirma" :key="firma.id" :value="firma.id" v-text="firma.nombre"></option>
                                        </select>
                                </div> 
                            </div>
                            </template>
                            
                            
                     </div>
                     
                     <div class="form-group row div-error">
                        <div class="text-center text-error">
                            <div v-for="error in errorMostrarMsjCertificado" :key="error" v-text="error">

                            </div>
                        </div>
                    </div>
                       
                         
                        <div class="form-group row">
                     <button type="button" class="btn btn-danger" @click="MirarResumen()">Cancel</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarPdfedicion(certificado_id)">Preview</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="actualizarCertificado()">To update</button>&nbsp;&nbsp;
                     <button type="button" v-if="tipoAccion==1" class="btn btn-warning" @click="generateCerti()">End Edit</button>&nbsp;&nbsp;
                     <template v-if="certificado.edicions_condicion==7">
                         
                     </template>
                     <template v-else>
                         <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="vistaPrevia()">Advanced Edition</button>&nbsp;&nbsp;
                     </template>
                     <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="registrarCertificado()">Initiate Certificate Issuance</button>
                        </div>             
                    </div>
            </template>

            <template v-else-if="listado==2">
                    <!-- Vista Previa -->
                    
                    <div class="card-body">
                        <div class="form-group row border">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <h2>Preview - Advanced Edition<br>
                                    <font color="red">(Enviar la captura de la nueva Edición al Gerente Técnico y Supervisor antes del Envío)</font></h2>
                                        
                                </div>  
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <textarea v-model="cabecera" cols="80" rows="10"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label v-html="cabecera"></label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="form-group">
                                </div>  
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                </div>  
                            </div>
                        </div>
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label v-html="description"></label>
                                </div>  
                            </div>
                            <div class="col-md-6">
                                <div id="app">
                                    <textarea v-model="description" cols="80" rows="10"></textarea>
                                </div>
                                                              
                            </div>
                        </div>
                            <div class="form-group row border">
                            <div class="col-md-12">
                                <template v-if="(level=='Intermediate Level' && tipo_certificado_id==1) || (level=='Intermediate Level' && tipo_certificado_id==2)">
                                    <div class="form-group">
                                    <textarea v-model="fecha_total" cols="80" rows="10"></textarea>
                                    <label v-html="fecha_total"></label>
                                    </div> 
                                </template>
                                <template v-else>
                                    <div class="form-group">
                                    <textarea v-model="fecha_total" cols="80" rows="10"></textarea>
                                    <label v-html="fecha_total"></label>

                                </div> 
                                    
                                </template>
                                
                            </div>
                            </div>
                            <div class="form-group row border">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong><label v-text="'Nota:'"></label></strong><br/>
                                    <label v-text="'<br/> : Genera un Salto de línea'"></label><br/>
                                    <label v-text="'&nbsp; : Genera un espacio en blanco'"></label><br/>
                                    <label v-text="'<b></b>: Pone en negrita todo el texto dentro de la etiqueta'"></label><br/>
                                    <label v-text="'<h1></h1>: Los h1, h2, h3, h4, h5 y h6 son encabezados donde el más grande es h1 y el más pequeño es h6.'"></label><br/> 

                                        
                                </div>  
                            </div>
                        </div>
                       <div class="form-group row">
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="actualizaradCertificado()">To update</button>&nbsp;&nbsp;
                        <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="cargarPdfedicion(certificado_id)">Preview</button>&nbsp;&nbsp;
                        <button type="button" v-if="tipoAccion==1" class="btn btn-warning" @click="generateCerti()">End Edit</button>&nbsp;&nbsp;
                        <button type="button" v-if="tipoAccion==1" class="btn btn-danger" @click="regreso_actualizacion()">To return</button>&nbsp;&nbsp;
                        </div>             
                    </div>
            </template>

            <template v-else-if="listado==3">
                    <!-- Datos de Carné -->
                    
                    <div class="card-body">
                        
                        <div class="form-group row border">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <strong><label v-text="'ID: '+ num_dni"></label><br>
                                    <label v-text="'Profesional:'"></label></strong><br>
                                    
                                    <input type="text" v-model="persona" class="form-control" disabled>
                                </div>  
                            </div>
                            
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <strong><label v-text="'# Certificate: B - 23.00'+certificado"></label><br>
                                    <label>Company:</label>
                                    <input type="text" v-model="empresa" class="form-control" disabled></strong>
                                </div>  
                            </div>
                        </div>

                        <div class="form-group row border">
                                <div class="col-md-6"> 
                                    <div class="form-group">
                                    <strong><label>Designacion: </label></strong>
                                        <template v-if="tipo_certificado_id==5">
                                            <strong><label>Operador de</label></strong>
                                        </template>
                                        <template v-else-if="tipo_certificado_id==6">
                                            <strong><label>Aparejador de</label></strong>
                                        </template>
                                        <template v-else-if="tipo_certificado_id==7">
                                            <strong><label>Supervisor de</label></strong>
                                        </template>
                                        <template v-else-if="tipo_certificado_id==8">
                                            <strong><label>Inspector de</label></strong>
                                        </template>
                                        <input type="text" v-model="designacion_espanol" class="form-control" disabled>
                                    </div>  
                                </div>
                                <template v-if="cond_equipo!=0">
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            <label>Equipo:</label>
                                            <input type="text" v-model="equipoes" class="form-control" disabled>
                                        </div>  
                                    </div>
                                </template>
                        </div>
                        
                        <div class="form-group row border">
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <strong><label>Normativa:</label></strong>
                                    <input type="text" v-model="normativaes" class="form-control" disabled>
                                </div>  
                            </div>
                            <div class="col-md-6"> 
                                <div class="form-group">
                                    <strong><label>Identifica:</label></strong>
                                    <input type="text" v-model="identifica" class="form-control" disabled>
                                </div>  
                            </div>

                        </div>
                          
                       <div class="form-group row">
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info" @click="cargarCarnePdfedicion(idcarne)">Preview</button>&nbsp;&nbsp;
                        <button type="button" v-if="tipoAccion==1" class="btn btn-danger" @click="MirarResumen()">Cancel</button>&nbsp;&nbsp;
                        <button type="button" v-if="tipoAccion==1" class="btn btn-warning" @click="EditionAdvan()">Advanced Edition</button>&nbsp;&nbsp;
                        <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="generateCarne()">End Edit</button>
                        </div>             
                    </div>
            </template>
            <template v-else-if="listado==4">
                    <!-- Datos de Carné -->
                    
                    <div class="card-body">
                        
                        <div class="form-group row border">
                            <div class="col-md-6">
                                <textarea v-model="nombrescarne" cols="80" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label v-html="nombrescarne"></label>
                            </div>

                            <div class="col-md-6">
                                <textarea v-model="empresacarne" cols="80" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label v-html="empresacarne"></label>
                            </div>
                            <div class="col-md-6">
                                <textarea v-model="designacioncarne" cols="80" rows="4" class="form-control"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label v-html="designacioncarne"></label>
                            </div>
                            <div class="col-md-6">
                            <div class="form-inline">
                                        <input type="text" class="form-control" v-model="num_dni" @keyup.enter="buscarFoto()" placeholder="Enter personnel ID ">
                                        <button @click="buscarFoto()" class="btn btn-primary">...</button>
                                        
                            </div>
                            <input type="text" v-model="foto" class="form-control">
                            </div>
                    </div>
                    <div class="form-group row border">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <strong><label v-text="'Nota:'"></label></strong><br/>
                                    <label v-text="'<br/> : Genera un Salto de línea'"></label><br/>
                                    <label v-text="'&nbsp; : Genera un espacio en blanco'"></label><br/>
                                    <label v-text="'<b></b>: Pone en negrita todo el texto dentro de la etiqueta'"></label><br/>
                                    <label v-text="'<h1></h1>: Los h1, h2, h3, h4, h5 y h6 son encabezados donde el más grande es h1 y el más pequeño es h6.'"></label><br/> 

                                        
                                </div>  
                            </div>
                        </div>
                          
                        <div class="form-group row">
                            <button type="button" v-if="tipoAccion==1" class="btn btn-info" @click="cargarCarnePdfedicion(idcarne)">Preview</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==1" class="btn btn-danger" @click="MirarResumen()">Return</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==1" class="btn btn-warning" @click="actualizarCarne()">To update</button>&nbsp;&nbsp;
                            <button type="button" v-if="tipoAccion==1" class="btn btn-success" @click="generateCarne()">End Edit</button>
                        </div>             
                    </div>
            </template>
            </div>
                <!-- Fin ejemplo de tabla Listado -->
            <!--Inicio del modal para fecha de Revalidación-->
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
                                    <label class="col-md-3 form-control-label" for="text-input">Fecha de Revalidación:</label>
                                    <div class="col-md-9">
                                        <input type="date" v-model="fecha_revalido" class="form-control" placeholder="Ingresar Fecha de Revalidación">
                                        
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
            <!--Inicio del modal para Solicitud de Edición de Certificado-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal1}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
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
                                    <label class="col-md-3 form-control-label" for="text-input"># de Certificado:</label> <label class="col-md-9 form-control-label" v-text="'B - 23.00'+certificado"></label>
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
                                                <td><input v-model="firma_edi"  type="checkbox"></td>
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

                
            </div>
            
            
        </main>
</template>



<script>

import moment from 'moment';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';
export default {
    name: 'app',
        data(){
            return{
                //editor de texto
                editor: ClassicEditor,
                editorData: '<p>Content of the editor.</p>',
                editorConfig: {
                    },

                //Datos de Table
                persona_id: 0,
                iddesignacion: 0,
                tipo_certificado_id: 5,
                firma_id:0,
                lote_id:0,
                certificado_id:0,
                idcarne:0,
                //Datos Personal
                dni:'',
                nombre:'',
                apellido:'',
                persona: '',
                identifica:'',
                foto:'',

                nombre_lote: '',
                cond_equipo: 1,
                dias: '',
                numero: '',
                num_dni:'',
                pdsi:'',
                empresa:'',
                certificado:'',
                designation:'',
                designacion_espanol:'',
                equipo:'',
                equipoes:'',
                tipo_certificados:'',
                level:'',
                horas:'',
                normativa:'',
                normativaes:'',
                qr:'',
                condicion:'',
                fecha_emision:'',
                fecha_emision2:'',
                fecha_emision3:'',
                fecha_emision4:'',
                fecha_emision5:'',
                fecha_emision6:'',
                fecha_emision7:'',
                fecha_revalidacion:'',
                fecha_expiracion:'',
                firma_nombre: '',
                description:'',
                cabecera:'',
                fecha_total:'',
                //buscar
                bpdsi:'',
                bempresa:'',
                bnumero:'',
                bnpersona:'',
                bapersona:'',
                btipo_certificado:'',
                //Campos para la Edicion de Certificados con Autorización
                nombre_edi:'',
                designacion_edi:'',
                normativa_edi:'',
                firma_edi:'',
                foto_edi:'',
                anulacion_edi:'',
                cliente:'',
                comentario:'',
                otros:'',
                //Carne - Editable
                fechacarne:'',
                designacioncarne:'',
                empresacarne:'',
                nombrescarne:'',
                fecha_revalido:'',
                //
                arrayCertificado: [],
                arrayLote: [],
                arrayFirma: [],
                arrayTipo_certificado: [],
                arrayDesignacionOperador: [],
                arrayDesignacionRigger: [],
                arrayDesignacionSupervisor: [],
                arrayDesignacionInspector: [],
                arrayDesignacionOtros: [],
                arraySenalero: [],
                arrayDesignacion: [],
                arrayPersona: [],
                arrayPersona1: [],
                modal : 0,
                modal1 : 0,
                tituloModal:'',
                tipoAccion : 0 ,
                listado: 1,
                errorRevision : 0,
                errorMostrarMsjCertificado : [],
                pagination : {
                'total'          : 0,
                'current_page'   : 0,
                'per_page'       : 0,
                'last_page'      : 0,
                'from'           : 0,
                'to'             : 0,
                },
                offset : 3,
                criterio : 'certificado',
                buscar :'',
                //Api Atom PDSI
                pdsi_atom: '',
                pdsi_all:'',
                prj_id:'',
                //Fin Api Atom
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
            listarCertificado(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado){
                let me=this;
                var url= '/consulta3?page=' + page + '&bpdsi='+ bpdsi+ '&bempresa='+ bempresa
                + '&bnumero='+ bnumero+ '&bnpersona='+ bnpersona + '&bapersona='+ bapersona+ '&btipo_certificado='+ btipo_certificado;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCertificado = respuesta.certificados.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                });
            },
            cargarPdf(){
                window.open('/certificadoC/certificadoPdf','_blanck');
            },
            cargarPdfedicion(id){
                window.open('/certificadoC/certificadoPdf/'+id,'_blanck')
            },
            cargarCarnePdfedicion(id){
                window.open('/carneC/carnePdf/'+id,'_blanck')
            },
            cargarCarnePdfemision1(id){
                window.open('/carneC/carnePdfEmision1/'+id,'_blanck')
            },
            cargarCarnePdfemision(id){
                window.open('/carneC/carnePdfEmision/'+id,'_blanck')
            },
            cargarPdfemision(id){
                window.open('/certificadoC/certificadoPdfEmision/'+id,'_blanck')
            },
            selectLote(){
                let me=this;
                var url='/lote/selectLoteUnico';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayLote = respuesta.lotes;
                    
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectFirma(){
                let me=this;
                var url='/firma/selectFirmaBo';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayFirma = respuesta.firmas;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectPersona(){
                let me=this;
                var url='/persona/selectPersona';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayPersona1 = respuesta.personas;
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
            selectDesignacionOperador(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=13';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionOperador = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectDesignacionRigger(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=14';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionRigger = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectDesignacionSupervisor(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=17';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionSupervisor = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectDesignacionInspector(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=15';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionInspector = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectDesignacionoOtros(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=16';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arrayDesignacionOtros = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            selectSenalero(){
                let me=this;
                var url='/designacion/selectDesignacion?idtipo_certificado=15';
                axios.get(url).then(function (response){
                    var respuesta = response.data;
                    me.arraySenalero = respuesta.designaciones;
                })
                .catch(function (error){
                    console.log(error);
                });

            },
            fecha (d){
                return moment(d).format("YYYY-MM-DD");
            },
            fechahoy (){
                return moment().format("YYYY-MM-DD");
            },

            MirarResumen(){
                this.listado=1;
                this.persona= '';
            },
            buscarPersona(){
                let me=this;
                var url= '/persona/buscarPersona?filtro=' + me.dni;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas;

                    if (me.arrayPersona.length>0){
                        me.persona=me.arrayPersona[0]['nombre']+' '+me.arrayPersona[0]['apellido'];
                        me.nombre=me.arrayPersona[0]['nombre'];
                        me.persona_id=me.arrayPersona[0]['id'];
                        me.apellido=me.arrayPersona[0]['apellido'];
                        me.dni=me.arrayPersona[0]['dni'];
                        me.empresa=me.arrayPersona[0]['empresa'];
                        me.foto=me.arrayPersona[0]['imagen'];
                    }
                    else{
                        me.articulo='No existe Profesional';
                        me.idpersona=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            buscarFoto(){
                let me=this;
                var url= '/persona/buscarPersona?filtro=' + me.num_dni;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas;

                    if (me.arrayPersona.length>0){
                        me.foto=me.arrayPersona[0]['imagen'];
                    }
                    else{
                        me.foto='No existe Profesional';
                        me.idpersona=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            buscarDesignacion(){
                let me=this;
                var url= '/designacion/buscarDesignacion?filtro=' + me.iddesignacion;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayDesignacion = respuesta.designaciones;

                    if (me.arrayDesignacion.length>0){
                        //me.designacion=me.arrayDesignacion[0]['designacion_ingles'];
                        //me.designacion_espanol=me.arrayDesignacion[0]['designacion_espanol'];
                        me.normativa=me.arrayDesignacion[0]['normativa_ingles'];
                        me.normativaes=me.arrayDesignacion[0]['normativa_espanol'];
                    }
                    else{
                        me.normativa='No existe Profesional';
                        me.iddesignacion=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado){
                let me = this;
                //Actualiza la pagina actual
                me.pagination.current_page = page;
                //envia peticion para visualizar la data de esa pagina 
                me.listarCertificado(page,bpdsi,bempresa,bnumero,bnpersona,bapersona,btipo_certificado);
            },
            vistaPrevia(){
                this.listado=2;
            },
            vistaCarne(){
                this.listado=3;
            },
            EditionAdvan(){
                this.listado=4;         
            },
            regreso_actualizacion(){
                this.listado=0;
            },
            generateCerti(){
                let me = this;
                    axios.put('/certificado/generateCerti1',
                    {
                        'certificado_id': this.certificado_id,
                        'id_edicions': this.id_edicions,
                    }).then(function (response) {
                        alert("Enviar la captura de la nueva Edición al Gerente Técnico y Supervisor antes del Envío");
                        me.listarCertificado(1,'','','','','','');
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                this.listado=1;
            },
            formData(){
                let me=this;
                const formData = new FormData;
                formData.set('id',this.idcarne)
                formData.set( 'fecha_revalido', this.fecha_revalido)
               
                if(this.idcarne!=''){
                    axios.post('/carne/revalidacion',formData).then(function (response){
                    console.log(response.data);
                    me.cerrarModal();
                    me.listarCertificado(1,'','','','','','');
                })
                .catch(function (error){
                    console.log(error);
                });    
                }             

            },
            formEdicion(){
                            let me=this;
                            const formData = new FormData;
                            formData.set('id',this.certificado_id)
                            formData.set( 'nombre_edi', this.nombre_edi)
                            formData.set( 'designacion_edi', this.designacion_edi)
                            formData.set( 'normativa_edi', this.normativa_edi)
                            formData.set( 'firma_edi', this.firma_edi)
                            formData.set( 'foto_edi', this.foto_edi)
                            formData.set( 'anulacion_edi', this.anulacion_edi)
                            formData.set( 'cliente', this.cliente)
                            formData.set( 'comentario', this.comentario)
                            if(this.certificado_id!=''){
                                axios.post('/certificado/edicion',formData).then(function (response){
                                console.log(response.data);
                                me.cerrarModal1();
                                me.listarCertificado(1,'','','','','','');
                            })
                            .catch(function (error){
                                console.log(error);
                            });    
                            }             

                        },


            registrarCertificado(){
                if (this.validarCertificado()){
                    return;
                }
                    
                    let me = this;
                    axios.post('/certificado/registrar',
                    {
                        'id': this.certificado_id,
                        'iddesignacion':this.iddesignacion,
                        'persona_id': this.persona_id,
                        'tipo_certificado_id': this.tipo_certificado_id,
                        'firma_id': this.firma_id,
                        'lote_id': this.lote_id,
                        'idcarne': this.idcarne,
                        'dni': this.dni,
                        'nombre': this.nombre,
                        'apellido': this.apellido,
                        'persona': this.persona,
                        'nombre_lote': this.nombre_lote,
                        'cond_equipo': this.cond_equipo,
                        'dias': this.dias,
                        'numero': this.numero,
                        'pdsi': this.pdsi,
                        'empresa': this.empresa,
                        'certificado': this.certificado,
                        'designacion': this.designation,
                        'equipo': this.equipo,
                        'equipoes': this.equipoes,
                        'tipo_certificados': this.tipo_certificados,
                        'level': this.level,
                        'normativa': this.normativa,
                        'normativaes': this.normativaes,
                        'horas': this.horas,
                        'fecha_emision': this.fecha_emision,
                        'fecha_emision2': this.fecha_emision2,
                        'fecha_emision3': this.fecha_emision3,
                        'fecha_emision4': this.fecha_emision4,
                        'fecha_emision5': this.fecha_emision5,
                        'fecha_emision6': this.fecha_emision6,
                        'fecha_emision7': this.fecha_emision7,
                    }).then(function (response) {
                        me.listarCertificado(1,'','','','','','');
                    
                }).catch(function (error) {
                    // handle error
                    console.log(error);
                });
                this.listado=1;
            },
            actualizarCertificado(){
                
                    let me = this;
                    axios.put('/certificadoC/actualizar1',{
                        'id_edicion':this.id_edicions,
                        'id': this.certificado_id,
                        'iddesignacion':this.iddesignacion,
                        'persona_id': this.persona_id,
                        'tipo_certificado_id': this.tipo_certificado_id,
                        'firma_id': this.firma_id,
                        'lote_id': this.lote_id,
                        'idcarne': this.idcarne,
                        'dni': this.dni,
                        'nombre': this.nombre,
                        'apellido': this.apellido,
                        'persona': this.persona,
                        'nombre_lote': this.nombre_lote,
                        'cond_equipo': this.cond_equipo,
                        'dias': this.dias,
                        'numero': this.numero,
                        'pdsi': this.pdsi,
                        'empresa': this.empresa,
                        'certificado': this.certificado,
                        'equipo': this.equipo,
                        'equipoes': this.equipoes,
                        'tipo_certificados': this.tipo_certificados,
                        'level': this.level,
                        'normativa': this.normativa,
                        'normativaes': this.normativaes,
                        'horas': this.horas,
                        'fecha_emision': this.fecha_emision,
                        'fecha_emision2': this.fecha_emision2,
                        'fecha_emision3': this.fecha_emision3,
                        'fecha_emision4': this.fecha_emision4,
                        'fecha_emision5': this.fecha_emision5,
                        'fecha_emision6': this.fecha_emision6,
                        'fecha_emision7': this.fecha_emision7,
                        }).then(function (response) {
                    me.cerrarModal();
                    me.listarCertificado(1,'','','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
                
            },
            actualizaradCertificado(){
                
                    let me = this;
                    axios.put('/certificadoC/actualizarad',{
                        'id': this.certificado_id,
                        'fecha': this.fecha_total,
                        'description': this.description,
                        'cabecera': this.cabecera,
                        }).then(function (response) {
                    me.cerrarModal();
                    me.listarCertificado(1,'','','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            generateCarne(){
                let me = this;
                    axios.put('/carne/emitir1',{
                        'id': this.idcarne,
                        'nombrescarne': this.nombrescarne,
                        'empresacarne': this.empresacarne,
                        'designacioncarne': this.designacioncarne,
                        'fechacarne': this.fechacarne,
                        'edicion': this.id_edicions,
                        'foto': this.foto,
                        }).then(function (response) {
                    me.cerrarModal();
                    me.listarCertificado(1,'','','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
                this.listado=1;
            },
            actualizarCarne(){
                let me = this;
                    axios.put('/carneC/actualizar',{
                        'id': this.idcarne,
                        'nombrescarne': this.nombrescarne,
                        'empresacarne': this.empresacarne,
                        'designacioncarne': this.designacioncarne,
                        'foto': this.foto,
                        }).then(function (response) {
                    me.cerrarModal();
                    me.listarCertificado(1,'','','','','','');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            desactivarCertificado(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Disable review',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Accept',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/certificadoC/desactivar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarCertificado(1,'','','','','','');
                        swalWithBootstrapButtons.fire(
                        'Disabled',
                        'Successfully deactivated',
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
            activarCertificado(id){
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger'
                    },
                    buttonsStyling: false
                    })

                    swalWithBootstrapButtons.fire({
                    title: 'Are you sure to activate Certificate',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Accept',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                    }).then((result) => {
                    if (result.value) {
                                        let me = this;
                                    axios.put('/certificadoC/activar',{
                                        'id': id
                                    }).then(function (response) {
                                    me.listarCertificado(1,'','','','','','');
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
            validarCertificado(){
                    this.errorCertificado=0;
                    this.errorMostrarMsjCertificado =[];
                    if(!this.pdsi) this.errorMostrarMsjCertificado.push("PDSI It cant be empty.");
                    if(!this.lote_id) this.errorMostrarMsjCertificado.push("Batch It cant be empty.");
                    if(!this.persona_id) this.errorMostrarMsjCertificado.push("Professional It cant be empty.");
                    if(!this.empresa) this.errorMostrarMsjCertificado.push("Company It cant be empty.");
                    if(!this.tipo_certificado_id) this.errorMostrarMsjCertificado.push("Certificate type It cant be empty.");
                    if(!this.level) this.errorMostrarMsjCertificado.push("Level It cant be empty.");
                    if(!this.horas) this.errorMostrarMsjCertificado.push("Hours cant be empty.");
                    if(!this.normativa) this.errorMostrarMsjCertificado.push("Normative type It cant be empty.");
                    if(!this.fecha_emision7) this.errorMostrarMsjCertificado.push("Day type It cant be empty.");
                    if(!this.firma_id) this.errorMostrarMsjCertificado.push("Signature type It cant be empty.");
                    if(this.errorMostrarMsjCertificado.length) this.errorCertificado = 1;
                    return this.errorCertificado;
           },
            cerrarModal(){
                    this.modal = 0;
                    this.tituloModal = '';
                    this.idusuario= '';
            },
            cerrarModal1(){
                    this.modal1 = 0;
                    this.tituloModal = '';
                    this.idusuario= '';
            },
            Verdetalle(modelo, accion, data = []){
                
                this.listado=0;
                this.selectFirma();
                this.selectLote();
                this.selectPersona();
                this.selectDesignacionOperador();
                this.selectDesignacionRigger();
                this.selectDesignacionSupervisor();
                this.selectDesignacionInspector();
                this.selectDesignacionoOtros();
                this.selectSenalero();
                this.selectTipo_Certificado();
                switch(modelo){
                    case "certificado":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.tituloModal = 'Generate New Certificate ';
                                    this.tipoAccion= 2;
                                    this.persona_id='';
                                    this.tipo_certificado_id=5;
                                    this.idcarne='';
                                    this.firma_id='';
                                    this.lote_id='';
                                    this.certificado_id='';
                                    this.iddesignacion='';
                                    this.equipoes='';
                                    this.dias=1;
                                    this.cond_equipo=1;
                                    //this.nombre='';
                                    //this.apellido='';
                                    this.nombre_lote='';
                                    this.numero='';
                                    this.pdsi='';
                                    //this.empresa='';
                                    this.certificado='';
                                    this.designation='';
                                    this.equipo='';
                                    this.tipo_certificados='';
                                    this.level='';
                                    this.horas='';
                                    this.normativa='';
                                    this.normativaes='';
                                    this.qr='';
                                    this.condicion='';
                                    this.fecha_emision='';
                                    this.fecha_emision2='';
                                    this.fecha_emision3='';
                                    this.fecha_emision4='';
                                    this.fecha_emision5='';
                                    this.fecha_emision6='';
                                    this.fecha_emision7='';
                                    this.firma_nombre='';
                                    this.cabecera='';
                                    this.fecha_total='';
                                    break;
                                }
                                case 'actualizar':
                                {
                                    console.log(data);
                                    this.tituloModal = 'Preview View - (Enviar la captura de la nueva Edición al Gerente Técnico y Supervisor antes del Envío)';
                                    this.tipoAccion= 1;
                                    this.persona_id= data['idpersona'];
                                    this.tipo_certificado_id= data['idtipo_certificado'];
                                    this.firma_id= data['idfirma'];
                                    this.lote_id= data['idlote'];
                                    this.certificado_id= data['id'];
                                    this.idcarne=data['idcarne'];
                                    this.iddesignacion= data['iddesignacion'];
                                    this.nombre= data['nombre'];
                                    this.apellido= data['apellido'];
                                    this.persona= data['persona'];
                                    this.nombre_lote= data['nombre_lote'];
                                    this.numero= data['numero'];
                                    this.lote= data['numero'+'nombre_lote'];
                                    this.pdsi= data['pdsi'];
                                    this.empresa= data['empresa'];
                                    this.certificado= data['certificado'];
                                    this.designation= data['designacion'];
                                    this.equipo= data['equipo'];
                                    this.equipoes= data['equipoes'];
                                    this.dias=data['dias'];
                                    this.cond_equipo=data['cond_equipo'];
                                    this.tipo_certificados= data['tipo_certificados'];
                                    this.level= data['level'];
                                    this.horas= data['horas'];
                                    this.normativa= data['normativa'];
                                    this.normativaes= data['normativaes'];
                                    this.qr= data['qr'];
                                    this.condicion= data['condicion'];
                                    this.fecha_emision= data['fecha_emision'];
                                    this.fecha_emision2= data['fecha_emision2'];
                                    this.fecha_emision3= data['fecha_emision3'];
                                    this.fecha_emision4= data['fecha_emision4'];
                                    this.fecha_emision5= data['fecha_emision5'];
                                    this.fecha_emision6= data['fecha_emision6'];
                                    this.fecha_emision7= data['fecha_emision7'];
                                    this.firma_nombre= data['firma_nombre'];
                                    this.description=data['description'];
                                    this.cabecera=data['cabecera'];;
                                    this.fecha_total=data['fecha'];;
                                    this.nombre_edi=data['nombre_empresa'];
                                    this.designacion_edi=data['edicions_designacion'];
                                    this.normativa_edi=data['otros'];
                                    this.firma_edi=data['edicions_firma'];
                                    this.foto_edi=data['foto'];
                                    this.anulacion_edi=data['anulacion'];
                                    this.id_edicions=data['id_edicions'];
                                    break;
                                }
                            }
                        }
                }
            },
            Vercarne(modelo, accion, data = []){
                this.selectTipo_Certificado();
                this.listado=3;
                this.selectFirma();
                this.selectLote();
                this.selectPersona();
                this.selectDesignacionOperador();
                this.selectDesignacionRigger();
                this.selectDesignacionSupervisor();
                this.selectDesignacionInspector();
                switch(modelo){
                    case "certificado":
                        {
                            switch(accion){
                                case 'registrar':
                                {
                                    this.tituloModal = 'Generate New Certificate ';
                                    this.tipoAccion= 2;
                                    this.persona_id='';
                                    this.tipo_certificado_id=5;
                                    this.firma_id='';
                                    this.lote_id='';
                                    this.idcarne='';
                                    this.certificado_id='';
                                    this.iddesignacion='';
                                    this.num_dni='';
                                    this.equipoes='';
                                    this.dias=1;
                                    this.cond_equipo=1;
                                    //this.nombre='';
                                    //this.apellido='';
                                    this.nombre_lote='';
                                    this.numero='';
                                    this.pdsi='';
                                    //this.empresa='';
                                    this.certificado='';
                                    this.designation='';
                                    this.designacion_espanol='';
                                    this.equipo='';
                                    this.tipo_certificados='';
                                    this.level='';
                                    this.horas='';
                                    this.normativa='';
                                    this.normativaes='';
                                    this.qr='';
                                    this.foto='';
                                    this.condicion='';
                                    this.fecha_emision='';
                                    this.fecha_emision2='';
                                    this.fecha_emision3='';
                                    this.fecha_emision4='';
                                    this.fecha_emision5='';
                                    this.fecha_emision6='';
                                    this.fecha_emision7='';
                                    this.firma_nombre='';
                                    this.cabecera='';
                                    this.fecha_total='';
                                    this.identifica='';
                                    this.fechacarne='';
                                    this.designacioncarne='';
                                    this.empresacarne='';
                                    this.nombrescarne='';
                                    break;
                                }
                                case 'actualizar':
                                {
                                    this.tituloModal = 'Preview View - (Enviar la captura de la nueva Edición al Gerente Técnico y Supervisor antes del Envío)';
                                    this.tipoAccion= 1;
                                    this.persona_id= data['idpersona'];
                                    this.tipo_certificado_id= data['idtipo_certificado'];
                                    this.firma_id= data['idfirma'];
                                    this.certificado_id= data['id'];
                                    this.iddesignacion= data['iddesignacion'];
                                    this.idcarne=data['idcarne'];
                                    this.nombre= data['nombre'];
                                    this.apellido= data['apellido'];
                                    this.persona= data['persona'];
                                    this.num_dni=data['dni'];
                                    this.nombre_lote= data['nombre_lote'];
                                    this.numero= data['numero'];
                                    this.lote= data['numero'+'nombre_lote'];
                                    this.pdsi= data['pdsi'];
                                    this.empresa= data['empresa'];
                                    this.certificado= data['certificado'];
                                    this.designation= data['designacion'];
                                    this.designacion_espanol= data['designacion_espanol'];
                                    this.equipo= data['equipo'];
                                    this.equipoes= data['equipoes'];
                                    this.dias=data['dias'];
                                    this.cond_equipo=data['cond_equipo'];
                                    this.tipo_certificados= data['tipo_certificados'];
                                    this.level= data['level'];
                                    this.horas= data['horas'];
                                    this.normativa= data['normativa'];
                                    this.normativaes= data['normativaes'];
                                    this.qr= data['qr'];
                                    this.condicion= data['condicion'];
                                    this.fecha_emision= data['fecha_emision'];
                                    this.fecha_emision2= data['fecha_emision2'];
                                    this.fecha_emision3= data['fecha_emision3'];
                                    this.fecha_emision4= data['fecha_emision4'];
                                    this.fecha_emision5= data['fecha_emision5'];
                                    this.fecha_emision6= data['fecha_emision6'];
                                    this.fecha_emision7= data['fecha_emision7'];
                                    this.firma_nombre= data['firma_nombre'];
                                    this.description=data['description'];
                                    this.cabecera=data['cabecera'];
                                    this.fecha_total=data['fecha'];
                                    this.identifica=data['identifica'];
                                    this.foto='';
                                    this.fechacarne=data['fechacarne'];;
                                    this.designacioncarne=data['designacioncarne'];;
                                    this.empresacarne=data['empresacarne'];;
                                    this.nombrescarne=data['nombrescarne'];;
                                    this.id_edicions=data['id_edicions'];
                                    break;
                                }
                                case 'reevalidacion':
                                {
                                    this.modal=1;
                                    this.tituloModal = 'Revalidación';
                                    this.tipoAccion= 1;
                                    this.idcarne=data['idcarne'];
                                    this.persona= data['persona'];
                                    this.certificado= data['certificado'];
                                    this.empresa= data['empresa'];
                                    this.num_dni=data['dni'];
                                    this.listado=1;

                                    
                                    break;
                                }
                                case 'edicioncerti':
                                {
                                    this.modal1=1;
                                    this.tituloModal = 'Solicitud de Edición de Certificado';
                                    this.tipoAccion= 1;
                                    this.certificado_id= data['id'];
                                    this.idcarne=data['idcarne'];
                                    this.persona= data['persona'];
                                    this.certificado= data['certificado'];
                                    this.nombre= data['nombre'];
                                    this.apellido= data['apellido'];
                                    this.fecha_emision7= data['fecha_emision7'];
                                    this.empresa= data['empresa'];
                                    this.num_dni=data['dni'];
                                    this.listado=1;

                                    
                                    break;
                                }
                            }
                        }
                }
            }
                
        },
        mounted() {
           this.listarCertificado(1,this.bpdsi,this.bempresa,this.bnumero,this.bnpersona,this.bapersona,this.btipo_certificado);
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
        background-color:none !important;
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