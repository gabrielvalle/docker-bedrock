# Docker Bedrock
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://packagist.org/packages/ekandreas/bladerunner)

*** WORK IN PROGRESS ***

AEKAB uses this package to enable Docker dev environment for WordPress Bedrock development.

## Requirements
[PHP Composer](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx)

[Docker Machine](https://docs.docker.com/machine/install-machine/) 

## Step by step, getting started

Install Bedrock
```bash
composer create-project roots/bedrock the_project
```

Step into the project folder
```bash
cd the_project
```

Install this package with composer and require-dev
```
composer require ekandreas/docker-bedrock:dev-master --dev
```

Run the containers (php+mysql)
```
vendor/bin/dep docker up
```

(browse to [the_project.dev](http://the_project.dev) and start developing)

Stop the containers (php+mysql)
```
dep docker stop
```

Restart the containers (php+mysql)
```
dep docker restart
```

## Parameters

...

