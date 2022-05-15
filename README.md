# Laravel 9 com Wire Ui

## Instalar as dependências

Executar na raíz do projeto:

```bash
docker run --rm \
-u "$(id -u):$(id -g)" \
-v $(pwd):/opt \
-w /opt \
laravelsail/php81-composer:latest \
composer install
```

## Iniciar a stack

Executar na raiz do projeto

```bash
sail up -d --build
```

## Banco de dados

Executar migrations e seeds:

```bash
php artisan migrate:refresh --seed
```
