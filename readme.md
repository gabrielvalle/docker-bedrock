# Docker Bedrock
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://packagist.org/packages/ekandreas/bladerunner)

*** WORK IN PROGRESS ***

AEKAB uses this package to enable Docker dev environment for Roots Bedrock project development.

## Requirements
[PHP Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

[Docker Machine](https://docs.docker.com/machine/install-machine/) 

## Step by step, getting started

Install Bedrock
```bash
composer create-project roots/bedrock theproject
```

Step into the project folder
```bash
cd theproject
```

Install this package with composer and require-dev
```bash
composer require ekandreas/docker-bedrock:dev-master --dev
```

Create a deploy file in root, eg:
```php
<?php
include_once 'vendor/ekandreas/docker-bedrock/recipe.php';

server('theproject.dev', 'default')
    ->env('container', 'bedrock')
    ->stage('development');
```

Run the containers (php+mysql)
```bash
vendor/bin/dep docker:up development
```

**Note!** Change your DNS so that the URL points to the docker machine!
Then browse to [the_project.dev](http://the_project.dev) and start develop your awesome web app.

Stop the containers (php+mysql)
```bash
dep docker:stop development
```

## Parameters

...

