# Introducción

La API se desarrolló utilizando el Lumen Framework y SQLite seguindo el TDD y SOLID

# Instrucciones

- PHP >= 7.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- SQLite PHP Extension

```bash
composer install
cp .env.example .env
php artisan migrate
vendor/bin/phpunit
```
