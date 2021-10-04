https://ghostscypher.medium.com/running-laravel-websockets-in-production-setting-up-websockets-for-a-single-application-7d8ac7827de0
https://github.com/albirrkarim/Laravel-Push-Notification



Em Bootstrap.js
```js
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
```

