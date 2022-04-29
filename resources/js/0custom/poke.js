const lifetime = process.env.MIX_SESSION_LIFETIME * 60 * 1000;
const interval = lifetime / process.env.MIX_POKE_TIMES;
const poke_expire_check = () => {
    if (navigator.onLine && new Date() - poke_last >= interval + lifetime) {
        window.location.reload();
    }
};

let poke_last = new Date();

const poke_renew = async () => {
    await fetch(route('poke'), {
        method: 'HEAD',
        cache: 'no-cache',
        redirect: 'error',
    }).then(data => {
        if (data.status === 204) {
            poke_last = new Date();
        }
        poke_expire_check();
    }).catch(error => {
        console.error('Error while poking: ', error);
    });
};

setInterval(() => {
    poke_renew();
}, interval);
document.addEventListener('visibilitychange', () => {
    if (document.visibilityState !== 'hidden') {
        poke_expire_check();
    }
}, false);
window.addEventListener('online', poke_expire_check, false);
