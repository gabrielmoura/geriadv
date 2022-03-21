# OpCache

## Config
```ini
opcache.enable=1
opcache.memory_consumption=512
opcache.interned_strings_buffer=64
opcache.max_accelerated_files=32531
opcache.validate_timestamps=0
opcache.save_comments=1
```
## Uso
Limpar OPcache:
```bash
php artesão opcache:clear
```
Mostrar configuração do OPcache:
```bash
php artesão opcache:config
```
Mostrar status do OPcache:
```bash
php artesão opcache:status
```
Pré-compile o código do seu aplicativo:
```bash
php artisan opcache:compile {--force}
```
Nota: opcache.dups_fix deve estar habilitado, ou use o --force sinalizador. Se você encontrar erros "Não é possível redeclarar a classe", habilite opcache.dups_fixou adicione o caminho da classe à lista de exclusão.

