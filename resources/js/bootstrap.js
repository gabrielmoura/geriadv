/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');


} catch (e) {
}
try {
    require('jquery-mask-plugin');
    $('.date').mask('00/00/0000');
    $('.time').mask('00:00:00');
    $('.date_time').mask('00/00/0000 00:00:00');
    $('.cep').mask('00000-000');
    $('.phone').mask('0000-0000');
    $('.tel').mask('(00) 00000-0000');
    $('.phone_us').mask('(000) 000-0000');
    $('.mixed').mask('AAA 000-S0S');
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.money2').mask("#.##0,00", {reverse: true});
    $('.ip_address').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/, optional: true
            }
        }
    });
    $('.ip_address').mask('099.099.099.099');
    $('.percent').mask('##0,00%', {reverse: true});
    $('.clear-if-not-match').mask("00/00/0000", {clearIfNotMatch: true});
    $('.placeholder').mask("00/00/0000", {placeholder: "__/__/____"});
    $('.fallback').mask("00r00r0000", {
        translation: {
            'r': {
                pattern: /[\/]/,
                fallback: '/'
            },
            placeholder: "__/__/____"
        }
    });
    $('.selectonfocus').mask("00/00/0000", {selectOnFocus: true});


}catch (e) {
}



///import route from 'ziggy-js';

///const response = await fetch('/api/ziggy');
///const Ziggy = await response.toJson();
/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */


/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

// let token = document.head.querySelector('meta[name="csrf-token"]');

// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

import Echo from "laravel-echo"

window.Pusher = require('pusher-js');
/*
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: '63eb73d334ef36fd16f052b7da254c05',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});
*/
/**
 * Notificação Especial por websocket
 * @type {Echo}
 */
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    wsHost: window.location.hostname, // Your domain
    encrypted: true,
    wsPort: 80, // Yor http port
    disableStats: false, // Change this to your liking this disables statistics
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
    disabledTransports: ['sockjs', 'xhr_polling', 'xhr_streaming'] // Can be removed
});

if (process.env.NODE_ENV !== 'production') {
    Pusher.logToConsole = true;
}

window.Echo.channel('MManhaes.1')
    .listen('.myevent', function(location) {
        console.log(location);
    });


/**
 * Notificação Push
 * https://github.com/albirrkarim/Laravel-Push-Notification

const { key, cluster } = window.Laravel.pusher
if (key) {
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        wsHost: window.location.hostname, // Your domain
        encrypted: true,
        wsPort: 80, // Yor http port
        disableStats: true, // Change this to your liking this disables statistics
        forceTLS: false,
        enabledTransports: ['ws'],
        disabledTransports: ['sockjs', 'xhr_polling', 'xhr_streaming'] // Can be removed
    })

    axios.interceptors.request.use(
        config => {
            config.headers['X-Socket-ID'] = window.Echo.socketId()
            return config
        },
        error => Promise.reject(error)
    )
}

window.axios = axios

 */

//Utilizado apenas no Profile, seção de Notificações
//require('bootstrap-toggle');
