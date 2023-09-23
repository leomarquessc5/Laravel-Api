# Running Laravel-job Project

### Running Docker

```
docker compose up -d
```

### Duplicate .ENV.EXAMPLE

Duplicate .env.example renaming it to .env

### Install Dependencies

```
docker compose exec app composer install
```

### Generate Key

```
docker compose exec app php artisan key:generate
```

### Rodando Migrations

```
docker compose exec app php artisan migrate:fresh --seed
```

### Configuring Postgres

PGAdmin Access

http://localhost:16543

```
user: admin@admin.com.br
password: admin
```

Server Access

```
host: postgres
port: 5432
user: postgres
password: admin
```
