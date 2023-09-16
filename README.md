# API Platform 3 Task for Devish - Made by Ali Mirza


## Setup

### Download Composer dependencies

Make sure you have [Composer installed](https://getcomposer.org/download/)
and then run:

```
composer install
```

You may alternatively need to run `php composer.phar install`, depending
on how you installed Composer.

### Start the Symfony web server

You can use Nginx or Apache, but Symfony's local web server
works even better.

To install the Symfony local web server, follow
"Downloading the Symfony client" instructions found
here: https://symfony.com/download - you only need to do this
once on your system.

Then, to start the web server, open a terminal, move into the
project, and run:

```
symfony serve
```

(If this is your first time using this command, you may see an
error that you need to run `symfony server:ca:install` first).


Now check out the site at 
```
https://localhost:8000/api
```
Run Docker
Make sure you have docker client up and running on your OS.
Run the following command to start the app in its docker container

```
docker compose up -d
```
DB remarks:
Simply head over to the api endpoints and add your own data.
They will be added to the dockerized PostgreSQL DB.

## Thanks!

Ali Mirza
ali.130782@gmail.com
