ATM Simulator

Steps to run:

```sh
$ composer install
$ php -S 127.0.0.1:8080 -t public
```

Steps to run tests:

```sh
$ docker run --rm --name atm -p 3306:3306 -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=atm -d mysql:8.0
$ cp .env.local .env
$ php artisan migrate
$ ./vendor/bin/phpunit tests
```