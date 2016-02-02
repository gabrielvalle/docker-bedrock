<?php

if (!class_exists('EkAndreas\DockerBedrock\Helpers')) {
    include_once 'src/DockerBedrock/Helpers.php';
}

use EkAndreas\DockerBedrock\Helpers;

$dir = Helpers::getProjectDir();
require_once $dir.'/vendor/autoload.php';

include_once $dir.'/vendor/deployer/deployer/recipe/common.php';

task('docker:start', function () {
    Helpers::start();
}, 999);

task('docker:up', function () {
    Helpers::start();
}, 999);

task('docker:stop', function () {
    Helpers::stop();
});

task('docker:halt', function () {
    Helpers::stop();
});

task('docker:kill', function () {
    Helpers::kill();
});
