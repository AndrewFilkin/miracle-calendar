# Run Laravel with Docker Compose

Copy git repository

```
git clone https://github.com/AndrewFilkin/docker-laravel.git name_project
```

`cd` project folder and run docker 

```bash
docker-compose up -d
```

Install laravel 

```
docker-compose run --rm composer create-project laravel/laravel .
```

Install debug bar

```
 docker-compose run --rm composer require barryvdh/laravel-debugbar --dev
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

## Redis
Download library

```bash
docker-compose run --rm composer require predis/predis
```

Change `.env` <br/>

```
REDIS_HOST=redis
REDIS_PASSWORD=null
#REDIS_PORT=6379
```

Change config/database.php <br/>

```
'redis' => [
        'client' => env('REDIS_CLIENT', 'predis'),
        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_') . '_database_'),
        ],
        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],
        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],
    ],
```

## Testing

Change `.env` <br/>
Other connection need to comment out

```
DB_CONNECTION=sqlite
DB_DATABASE=:memory:
```


In file `phpunit.xml` uncomment lines <br/>

```
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

xDebug phpstorm setting

Try to run xDebug, An auto-configuration window should be displayed

```
Server name: localhost
Server port: 80
Request url: /
File path to server: /var/www/laravel/public/index.php
Manuale choice local file or project .../public/index.php
```

Add service if 

```
PhpStorm->Setting->php->service
Next to the src folder add: /var/www/laravel
Watch: https://www.youtube.com/watch?v=Oo0NuxIzgHo
```

<div align="center"> Developed With Love ! ❤️</div>

