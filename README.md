# Event Engine - PHP InspectIO Cody

This is the repository of the Cody server. [prooph board](https://prooph-board.com/ "prooph board") can 
connect to a coding bot called [Cody](https://wiki.prooph-board.com/cody/php-cody-tutorial.html "PHP Cody Tutorial"). 
With its help you can generate working code from an event map.

Cody server runs at [http://localhost:3311](http://localhost:3311)

## Installation

> There is also an [Event Engine Cody Skeleton](https://github.com/proophboard/php-cody-engine-skeleton) available.

Please make sure you have installed [Docker](https://docs.docker.com/install/ "Install Docker")
and [Docker Compose](https://docs.docker.com/compose/install/ "Install Docker Compose").

It is recommended to create a new application for code generation which installs this library via Composer. This allows
independence of your application code and avoids running in Composer dependency conflicts.

```bash
$ composer require event-engine/php-inspectio-cody
```

### Configuration

The following commands copies the necessary files from this library to the root of your application folder.

```
cp vendor/event-engine/php-inspectio-cody/public .
cp vendor/event-engine/php-inspectio-cody/.env.dist ./.env
cp vendor/event-engine/php-inspectio-cody/.env.dist .
cp vendor/event-engine/php-inspectio-cody/app.env.dist ./app.env
cp vendor/event-engine/php-inspectio-cody/app.env.dist .
cp vendor/event-engine/php-inspectio-cody/codyconfig.php .
cp vendor/event-engine/php-inspectio-cody/docker-compose.yml .
cp vendor/event-engine/php-inspectio-cody/php-watcher.yml.dist .
```

To mount our business application folder to the Cody server you have to update the `docker-compose.yml` file. Please
take a look at the [Cody](https://wiki.prooph-board.com/cody/php-cody-tutorial.html "PHP Cody Tutorial") for more
details.

## Start Cody Server

To start the Cody server execute the following command. You should be able to connect from *InspectIO* to the Cody server
via the URL `http://localhost:3311`.

```
$ docker-compose up -d --no-recreate
```
