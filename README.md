# Run Laravel with Docker Compose

Copy git repository

```
git clone ...
```

`cd` project folder and run docker 

```bash
docker-compose up -d
```

.env setting pgsql
```
DB_CONNECTION=pgsql
DB_HOST=pgsql
DB_PORT=5432
DB_DATABASE=miracle_calendar_db
DB_USERNAME=laravel
DB_PASSWORD=Y0BjvMe0TO3Bs0R
```

Run artisan command migrate

```bash
docker-compose run --rm artisan migrate
```

Run Db seed
```
docker-compose run --rm artisan db:seed
```

create the symbolic link

```
docker-compose run --rm artisan storage:link
```
