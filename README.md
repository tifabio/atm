[![CodeFactor](https://www.codefactor.io/repository/github/tifabio/atm/badge)](https://www.codefactor.io/repository/github/tifabio/atm)

# ATM Simulator

### Steps to install:

```sh
$ cp .env.local .env
$ docker-compose up -d --build
$ docker-compose exec app composer install
$ docker-compose exec app php artisan migrate --seed
```

### Steps to run:
```sh
$ docker-compose up -d
```

### Steps to run tests:

```sh
$ docker-compose exec app vendor/bin/phpunit
```

### API Documentation:
https://tifabio.github.io/atm