window._ = require('lodash');
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

require('./bootstrap');
require('./0custom/client');
if(process.env.MIX_WEBPUSH_ENABLE===true) {
    require('./web-push1/main');
}
if(isNumber(process.env.MIX_POKE_TIMES)) {
    require('./0custom/poke');
}

//window.toUint8Array = require('base64-to-uint8array');
// window.Vue = require('vue');
import Vue from 'vue'

import NotificationsDemo from './components/NotificationsDemo.vue'
import NotificationsDropdown from './components/NotificationsDropdown.vue'

/* eslint-disable-next-line no-new */
/*
new Vue({
    el: '#app',

    components: {
        NotificationsDemo,
        NotificationsDropdown
    }
})
*/
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });

import './masonry';
import './charts';
import './popover';
import './scrollbar';
import './search';
import './sidebar';
import './skycons';
import './vectorMaps';
import './chat';
import './datatable';
import './datetimepicker';
import './email';
import './fullcalendar';
import './googleMaps';
import './utils';

import './sweetalert2';
import './select2';

import './tynimce';
import './toastr';


//import 'toastr/toastr';
//import('./maskmoney');

window.printDiv = function (divName) {
    var printContents = document.getElementById(divName).innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;

    window.print();

    document.body.innerHTML = originalContents;
}

