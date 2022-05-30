
/*
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
*/

require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
Vue.use(Vuetify)

import VueRouter from 'vue-router'
Vue.use(VueRouter)

import { Form, HasError, AlertError } from 'vform';

window.Form = Form;
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

import Gate from "./Gate";
Vue.prototype.$gate = new Gate(window.user);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

import Swal from 'sweetalert2'
window.Swal = Swal;

const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})
window.Toast = Toast;

import VueProgressBar from 'vue-progressbar'
Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '2px'
})

let routes = [
    //VISTAS USUARIOS
    { path: '/inicio', component: require('./components/Inicio.vue').default },    
    { path: '/perfil', component: require('./components/users/Profile.vue').default },

    //VISTAS ADMIN
    { path: '/home', component: require('./components/Dashboard.vue').default },        
    { path: '/usuariosHoy', component: require('./components/inicio/Usuarios_del_Dia.vue').default },        
    { path: '/forosHoy', component: require('./components/inicio/Foros_del_Dia.vue').default },        
    { path: '/comentariosHoy', component: require('./components/inicio/Comentarios_del_Dia.vue').default },        

    //ADMINISTRACION
    { path: '/usuarios', component: require('./components/users/Users.vue').default },    
    { path: '/desarrollador', component: require('./components/users/Developer.vue').default}, 

    { path: '/crearFacultad', component: require('./components/facultades/CrearFacultad.vue').default },
    { path: '/facultades', component: require('./components/facultades/Facultades.vue').default },

    { path: '/crearCarrera', component: require('./components/carreras/CrearCarrera.vue').default },
    { path: '/carreras', component: require('./components/carreras/Carreras.vue').default },

    { path: '/crearCategoria', component: require('./components/categorias/CrearCategoria.vue').default },
    { path: '/categorias', component: require('./components/categorias/Categorias.vue').default },

    { path: '/crearSeccion', component: require('./components/secciones/CrearSeccion.vue').default },
    { path: '/secciones', component: require('./components/secciones/Secciones.vue').default },        

    { path: '/crearInformacion', component: require('./components/informaciones/crearInformacion.vue').default },
    { path: '/informaciones', component: require('./components/informaciones/Informaciones.vue').default },

    { path: '/foros', component: require('./components/foros/Foros.vue').default },
    { path: '/comentarios', component: require('./components/foros/ComentariosForo.vue').default },
    
    { path: '/crearGuia', component: require('./components/guias/CrearGuia.vue').default },   
    { path: '/guias', component: require('./components/guias/Guias.vue').default },   
    
    { path: '/crearPasos', component: require('./components/pasos/Crearpaso.vue').default },     
    { path: '/pasos', component: require('./components/pasos/Pasos.vue').default },    

    //PERSONALIZACION
    { path: '/carrusel', component: require('./components/personalizacion/Carrusel.vue').default },
    { path: '/colores', component: require('./components/personalizacion/Colores.vue').default },
    { path: '/detalles', component: require('./components/personalizacion/Detalles.vue').default },    
    
]

const router = new VueRouter({
    mode: "history",
    routes, // short for `routes: routes`
})

Vue.filter('upText', function(text){
    return text.charAt(0).toUpperCase() + text.slice(1)
});

window.Fire =  new Vue();

//COMPONENTES
Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/users/NotFound.vue')
);
Vue.component(
    'option-navbar',
    require('./components/OptionNavbar.vue').default
);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({    
    el: '#app',
    vuetify: new Vuetify(),
    router
});


