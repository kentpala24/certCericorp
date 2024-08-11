/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
/**_
*Vue.filter ('timeformat', (arg)=>{
*    return moment(arg).format("MM-DD-YYYY")
*})
*_
*/


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

import Vue from 'vue'
import CKEditor from '@ckeditor/ckeditor5-vue';
import VueQRCodeComponent from 'vue-qr-generator'
Vue.component('qr-code', VueQRCodeComponent)
Vue.component('persona', require('./components/Persona.vue').default);
Vue.component('rol', require('./components/Rol.vue').default);
Vue.component('user', require('./components/User.vue').default);
Vue.component('lote', require('./components/Lote.vue').default);
Vue.component('solicitud', require('./components/Solicitud.vue').default);
Vue.component('aprobacion', require('./components/Aprobacion.vue').default);
Vue.component('autorizacion', require('./components/Autorizacion.vue').default);
Vue.component('certificado', require('./components/Certificado.vue').default);
Vue.component('generar-certificado', require('./components/GenerarCertificado.vue').default);
Vue.component('certificado-pdsi', require('./components/CertificadoPDSI.vue').default);
Vue.component('edicion-certificado', require('./components/EdicionCertificado.vue').default);
Vue.component('tipo', require('./components/Tipo_certificado.vue').default);
//Vue.component('tipoEquipo', require('./components/TipoEquipo.vue').default);
Vue.component('dashboard', require('./components/Dashboard.vue').default);

Vue.component('carne', require('./components/Carne.vue').default);
Vue.component('carnerevalidacion', require('./components/Revalidacion.vue').default);
Vue.component('equipo', require('./components/Equipo.vue').default);
Vue.component('aprobacion-edicion', require('./components/Aprobacion_edi.vue').default);
//ISO 17024
Vue.component('persona-certifica', require('./components/PersonaCertifica.vue').default);
Vue.component('designacion-certifica', require('./components/DesignacionCertifica.vue').default);
Vue.component('certificado-certifica', require('./components/CertificadoCertifica.vue').default);
Vue.component('firma-certifica', require('./components/FirmaCertifica.vue').default);
Vue.component('edicion-certificado17024', require('./components/EdicionCertificadoCert.vue').default);
Vue.component('aprobacion-edicion17024', require('./components/AprobacionediCert.vue').default);
Vue.component('designacion', require('./components/DatoEquipo.vue').default);
Vue.component('firma', require('./components/TipoEquipo.vue').default);

Vue.component('ver-certificado-personas-v', require('./components/VerCertificadoPersonas.vue').default);
Vue.component('ver-certificado-equipos-v', require('./components/VerCertificadoEquipos.vue').default);


Vue.use( CKEditor );

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data :{
        menu : 0
    }
});
