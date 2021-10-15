'use strict';
import * as $ from 'jquery';
// Adaptação do Modelo: https://developers.google.com/web/updates/2015/03/push-notifications-on-the-open-web?hl=es-419#register_a_service_worker
const swReady = navigator.serviceWorker.ready;
window.isPushEnabled = false;

document.addEventListener('DOMContentLoaded', function () {
    initialiseState();
    initSW();
    $('#push-select').change(function () {
        if (window.isPushEnabled) {
            unsubscribe();
            console.log('Service Worker disabled');
        } else {
            subscribeUser();
            console.log('Service Worker enabled');
        }
    });


});

function initSW() {
    // As notificações são compatíveis com o service worker?
    if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
        console.warn('Notifications aren\'t supported.');
        return;
    }

    // Verifique a permissão de notificação atual.
    // Se for negado, é um bloqueio permanente até o
    // o usuário muda a permissão
    if (Notification.permission === 'denied') {
        console.warn('The user has blocked notifications.');
        return;
    }


    if (!"serviceWorker" in navigator) {
        //Service Worker não é compatível
        return;
    }

    //não use aqui se você usar service worker
    //para outras coisas.
    if (!"PushManager" in window) {
        //push não é suportado
        //console.warn('Push messaging isn\'t supported.');
        return;
    }

    //registre o trabalhador de serviço
    navigator.serviceWorker.register('../sw.js')
        .then(() => {
            console.log('serviceWorker installed!')
            initPush();
        })
        .catch((err) => {
            console.warn('Service workers aren\'t supported in this browser.');
        });
}

function initPush() {
    if (!swReady) {
        return;
    }

    new Promise(function (resolve, reject) {
        const permissionResult = Notification.requestPermission(function (result) {
            resolve(result);
        });

        if (permissionResult) {
            permissionResult.then(resolve, reject);
        }
    })
        .then((permissionResult) => {
            if (permissionResult !== 'granted') {
                throw new Error('We weren\'t granted permission.');
            }
            if (!window.isPushEnabled) {
                //subscribeUser();
            }
        });
}

/**
 * Subscribe the user to push
 */
function subscribeUser() {
    swReady
        .then((registration) => {
            const subscribeOptions = {
                userVisibleOnly: true,
                applicationServerKey: urlBase64ToUint8Array(
                   process.env.MIX_VAPID_PUBLIC_KEY
                )
            };
            window.isPushEnabled=true;
            return registration.pushManager.subscribe(subscribeOptions);
        })
        .then((pushSubscription) => {
            console.log('Received PushSubscription: ', JSON.stringify(pushSubscription));
            storePushSubscription(pushSubscription);
        });
}

/**
 * storePushSubscription
 * send PushSubscription to server with AJAX.
 * @param {object} pushSubscription
 */
function storePushSubscription(pushSubscription) {
    const token = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    fetch('/push', {
        method: 'POST',
        body: JSON.stringify(pushSubscription),
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-Token': token
        }
    })
        .then((res) => {
            return res.json();
        })
        .then((res) => {
            console.log(res)
        })
        .catch((err) => {
            console.log(err)
        });
}

/**
 * urlBase64ToUint8Array
 *
 * @param {string} base64String a public vapid key
 */
function urlBase64ToUint8Array(base64String) {
    var padding = '='.repeat((4 - base64String.length % 4) % 4);
    var base64 = (base64String + padding)
        .replace(/\-/g, '+')
        .replace(/_/g, '/');

    var rawData = window.atob(base64);
    var outputArray = new Uint8Array(rawData.length);

    for (var i = 0; i < rawData.length; ++i) {
        outputArray[i] = rawData.charCodeAt(i);
    }
    return outputArray;
}

/**
 * unsubscribe
 * Remove Inscrição Push do usuário
 */
function unsubscribe() {

    //$('#push-select').prop('checked', true).change();

    swReady.then(function (serviceWorkerRegistration) {
        // To unsubscribe from push messaging, you need get the
        // subscription object, which you can call unsubscribe() on.
        serviceWorkerRegistration.pushManager.getSubscription().then(
            function (pushSubscription) {
                // Check we have a subscription to unsubscribe
                if (!pushSubscription) {
                    // No subscription object, so set the state
                    // to allow the user to subscribe to push
                    window.isPushEnabled = false;
                    $('#push-select').prop('checked', false).change();
                    return;
                }

                var subscriptionId = pushSubscription.subscriptionId;
                // TODO: Make a request to your server to remove
                // the subscriptionId from your data store so you
                // don't attempt to send them push messages anymore

                // We have a subscription, so call unsubscribe on it
                pushSubscription.unsubscribe().then(function (successful) {
                    $('#push-select').prop('checked', false).change();
                    window.isPushEnabled = false;
                }).catch(function (e) {
                    // We failed to unsubscribe, this can lead to
                    // an unusual state, so may be best to remove
                    // the users data from your data store and
                    // inform the user that you have done so

                    console.log('Unsubscription error: ', e);
                    $('#push-select').prop('checked', false).change();
                });
            }).catch(function (e) {
            console.error('Error thrown while unsubscribing from push messaging.', e);
        });
    });
}

/**
 * initialiseState
 * Assim que o service worker estiver registrado, defina o estado inicial
 */
function initialiseState() {
    //  Define Botão para falso
    //$('#push-select').prop('checked', false).change();

    // Are Notifications supported in the service worker?
    if (!('showNotification' in ServiceWorkerRegistration.prototype)) {
        console.warn('Notifications aren\'t supported.');
        return;
    }

    // Check the current Notification permission.
    // If its denied, it's a permanent block until the
    // user changes the permission
    if (Notification.permission === 'denied') {
        console.warn('The user has blocked notifications.');
        return;
    }

    // Check if push messaging is supported
    if (!('PushManager' in window)) {
        console.warn('Push messaging isn\'t supported.');
        return;
    }

    // We need the service worker registration to check for a subscription
    swReady.then(function (serviceWorkerRegistration) {
        // Do we already have a push message subscription?
        serviceWorkerRegistration.pushManager.getSubscription()
            .then(function (subscription) {
                // Enable any UI which subscribes / unsubscribes from
                // push messages.
                $('#toggle-trigger').prop('checked', true).change();

                //if (!subscription) {
                // We aren't subscribed to push, so set UI
                // to allow the user to enable push
                //return;
                //}

                // Keep your server in sync with the latest subscriptionId
                //sendSubscriptionToServer(subscription);
                storePushSubscription(subscription);

                // Set your UI to show they have subscribed for
                // push messages
                //pushButton.textContent = 'Disable Push Messages';
                window.isPushEnabled = true;
            })
            .catch(function (err) {
                console.warn('Error during getSubscription()', err);
            });
    });
}

