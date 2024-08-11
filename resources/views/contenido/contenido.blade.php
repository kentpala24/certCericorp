    @extends('principal')
    @section('contenido')   
        @if(Auth::check())
            @if(Auth::user()->idrol==1)
            <template v-if="menu==0">
            <dashboard></dashboard>
            </template> 
            <template v-if="menu==1">
                <lote></lote>
            </template>
            <template v-if="menu==2">
                <solicitud></solicitud>
            </template>
            <template v-if="menu==3">
                <aprobacion></aprobacion>
            </template> 
            <template v-if="menu==4">
                <revision></revision>
            </template> 
            <template v-if="menu==5">
            <autorizacion></autorizacion>
            </template> 
            <template v-if="menu==6">
                <certificado></certificado>
            </template>

            <template v-if="menu==7">
            <generar-certificado></generar-certificado>
            </template> 


            <template v-if="menu==8">
            <designacion></designacion>
            </template> 

            <template v-if="menu==9">
                <persona></persona>
            </template>   

            <template v-if="menu==10">
                <user></user>
            </template> 

        <template v-if="menu==11">
            <rol></rol>
        </template> 
        <template v-if="menu==13">
            <tipo></tipo>
        </template> 
        <template v-if="menu==40">
            <firma></firma>
        </template> 
        <template v-if="menu==15">
            <carnerevalidacion></carnerevalidacion>
        </template> 
        <template v-if="menu==16">
            <equipo></equipo>
        </template>
        <template v-if="menu==18">
            <carne></carne>
        </template> 
        <template v-if="menu==19">
                <edicion-certificado></edicion-certificado>
                </template>
                <template v-if="menu==20">
                <aprobacion-edicion></aprobacion-edicion>
                </template>

        <template v-if="menu==21">
        <persona-certifica></persona-certifica>
        </template>
        <template v-if="menu==22">
        <designacion-certifica></designacion-certifica>
        </template>
        <template v-if="menu==23">
        <certificado-certifica></certificado-certifica>
        </template>
        <template v-if="menu==24">
        <firma-certifica></firma-certifica>
        </template>
        <template v-if="menu==25">
        <edicion-certificado17024></edicion-certificado17024>
        </template>
        <template v-if="menu==26">
        <aprobacion-edicion17024></aprobacion-edicion17024>
        </template>
        <template v-if="menu==27">
            <certificado-pdsi></certificado-pdsi>
            </template> 

            <template v-if="menu==50">
            <ver-certificado-equipos-v></ver-certificado-equipos-v>
            </template> 
            <template v-if="menu==51">
            <ver-certificado-personas-v></ver-certificado-personas-v>
            </template> 

            @elseif(Auth::user()->idrol==2)
                <template v-if="menu==0">
                <dashboard></dashboard>
                </template> 
                <template v-if="menu==1">
                <lote></lote>
                </template>
                <template v-if="menu==5">
                <autorizacion></autorizacion>
                 </template> 
                
                <template v-if="menu==6">
                <h1>Certificates</h1>
                </template>
            @elseif(Auth::user()->idrol==3)
                <template v-if="menu==0">
                <dashboard></dashboard>
                </template> 
                <template v-if="menu==1">
                <lote></lote>
                </template>
                <template v-if="menu==6">
                <certificado></certificado>
                </template>
                <template v-if="menu==19">
                <edicion-certificado></edicion-certificado>
                </template>
                <template v-if="menu==20">
                <aprobacion-edicion></aprobacion-edicion>
                </template>
                <template v-if="menu==25">
                <edicion-certificado17024></edicion-certificado17024>
                </template>
                <template v-if="menu==26">
                <aprobacion-edicion17024></aprobacion-edicion17024>
                </template>
                
            @elseif(Auth::user()->idrol==4)
                <template v-if="menu==0">
                <dashboard></dashboard>
                </template> 
                <template v-if="menu==1">
                <lote></lote>
                </template>
                <template v-if="menu==2">
                <solicitud></solicitud>
                </template>
                <template v-if="menu==3">
                <aprobacion></aprobacion>
                </template> 
                <template v-if="menu==6">
                <certificado></certificado>
                </template>
            @elseif(Auth::user()->idrol==5)
                <template v-if="menu==0">
                <dashboard></dashboard>
                </template> 
                <template v-if="menu==1">
                <lote></lote>
                </template>
                <template v-if="menu==2">
                <solicitud></solicitud>
                </template>
                
                <template v-if="menu==6">
                <certificado></certificado>
                 </template>
                 <template v-if="menu==7">
                 <generar-certificado></generar-certificado>
                </template>
                <template v-if="menu==19">
                <edicion-certificado></edicion-certificado>
                </template>
                <template v-if="menu==25">
                <edicion-certificado17024></edicion-certificado17024>
                </template>
                <template v-if="menu==14">
                <designacion></designacion>
                </template> 
                <template v-if="menu==15">
                    <carnerevalidacion></carnerevalidacion>
                </template> 
                <template v-if="menu==16">
                    <equipo></equipo>
                </template>
                <template v-if="menu==18">
                <carne></carne>
                </template> 

                <template v-if="menu==8">
                <tipoEquipo-certifica></tipoEquipo-certifica>
                </template> 

                <template v-if="menu==9">
                    <persona></persona>
                </template>  
                 
            @elseif(Auth::user()->idrol==6)
                <template v-if="menu==50">
                <ver-certificado-equipos-v></ver-certificado-equipos-v>
                </template> 
                <template v-if="menu==51">
                <ver-certificado-personas-v></ver-certificado-personas-v>
                </template> 
            @endif
        
        @endif
        

        
    @endsection