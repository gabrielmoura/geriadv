# Instalação e Configuração do Varnish com Hitch


## Instalação

## Configuração

### Configuração Hitch

copie ***/usr/share/doc/hitch/examples/hitch.conf.example\*** to ***/etc/hitch/hitch.conf\***

em /etc/hitch/hitch.conf:

```ini
pem-file = "/etc/letsencrypt/live/example.com/hitch-bundle.pem"
backend = "[localhost]:8443"
workers = 4      # number of CPU cores
alpn-protos = "http/2, http/1.1"

# run Varnish as backend over PROXY; varnishd -a :80 -a localhost:6086,PROXY ..
write-proxy-v2 = on             # Write PROXY header
```

em /usr/local/bin/hitch-deploy-hook:

```bash
#!/bin/bash
# Full path to pre-generated Diffie Hellman Parameters file
dhparams=/etc/hitch/dhparams.pem

if [[ "${RENEWED_LINEAGE}" == "" ]]; then
    echo "Error: missing RENEWED_LINEAGE env variable." >&2
    exit 1
fi

umask 077
cat ${RENEWED_LINEAGE}/privkey.pem \
${RENEWED_LINEAGE}/fullchain.pem \
${dhparams} > ${RENEWED_LINEAGE}/hitch-bundle.pem
```

```bash
sudo chmod a+x /usr/local/bin/hitch-deploy-hook
```

```bash
openssl dhparam 2048 | sudo tee /etc/hitch/dhparams.pem
```


```bash
sudo systemctl enable hitch
```

### Configuração Varnish

em /etc/varnish/letsencrypt.vcl:

```ini
vcl 4.1;

backend certbot {
    .host = "127.0.0.1";
    .port = "8080";
}

sub vcl_recv {
    if (req.url ~ "^/\.well-known/acme-challenge/") {
        set req.backend_hint = certbot;
        return(pipe);
    }
}

sub vcl_pipe {
    if (req.backend_hint == certbot) {
        set req.http.Connection = "close";
        return(pipe);
    }
}
```

em /etc/varnish/default.vcl:

```ini
include "/etc/varnish/letsencrypt.vcl";
backend server1 {
    .host = "127.0.0.1";
    .port = "8090";
}
```

```bash
sudo systemctl edit --full varnish
```

```ini
ExecStart=/usr/sbin/varnishd -a :80 -a localhost:8443,proxy -f /etc/varnish/default.vcl -s malloc,256m
```

```bash
sudo systemctl enable varnish
sudo systemctl start varnish
```

#### Redirecionamento Permanente HTTPS

em /etc/varnish/default.vcl:

```ini
import std;
include "/etc/varnish/letsencrypt.vcl";
backend server1 {
    .host = "127.0.0.1";
    .port = "8090";
}
sub vcl_recv {
    if (std.port(server.ip) != 443) {
        set req.http.location = "https://" + req.http.host + req.url;
        return(synth(301));
    }
}
sub vcl_synth {
        if (resp.status == 301) {
                set resp.http.location = req.http.location;
		  set resp.status = 301;
                return (deliver);
        }
}
```

### Configuração Certbot

```bash
sudo certbot certonly --standalone --preferred-challenges http \
--http-01-port 8080 -d example.com -d www.example.com \
--deploy-hook="/usr/local/bin/hitch-deploy-hook" \
--post-hook="systemctl reload hitch"
```

```bash
sudo systemctl enable certbot-renew.timer
sudo systemctl start certbot-renew.timer
```

### Configuração do NGINX

Para saber worker_processes:

```bash
echo $(($(grep processor /proc/cpuinfo | wc -l)-1))
```

Para saber worker_connections:

```bash
ulimit -n
```

em /etc/nginx/nginx.conf

```bash

#user http;
worker_processes  7;
#worker_connections 1024;

#error_log  logs/error.log;
#error_log  logs/error.log  notice;
#error_log  logs/error.log  info;

#pid        logs/nginx.pid;


events {
    worker_connections  1024;
}


http {
    include       mime.types;
    default_type  application/octet-stream;

    #log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
    #                  '$status $body_bytes_sent "$http_referer" '
    #                  '"$http_user_agent" "$http_x_forwarded_for"';

    #access_log  logs/access.log  main;

    sendfile        on;
    #tcp_nopush     on;

    #keepalive_timeout  0;
    keepalive_timeout  65;

    #gzip  on;

    include /etc/nginx/conf.d/*.conf;
    }
}

```



em **/etc/nginx/conf.d/seusite.conf**:

```ini
server {
        listen       8090;
        server_name  www.seusite.lan;
        root         /var/www/html/seusite.lan/;
        location / {
        }

        error_page 404 /404.html;
            location = /40x.html {
        }
        error_page 500 502 503 504 /50x.html;
            location = /50x.html {
        }
        location ~* .(jpg|jpeg|png|gif|ico|css|js)$ {
			expires 365d;
		}
}
```


