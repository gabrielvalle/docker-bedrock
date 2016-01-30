<?php
if(!class_exists('EkAndreas\DockerBedrock\Helpers')) include_once 'src/DockerBedrock/Helpers.php';

use EkAndreas\DockerBedrock\Helpers;

$dir = Helpers::getProjectDir();
require_once($dir . '/vendor/autoload.php');

include_once($dir.'/vendor/deployer/deployer/recipe/common.php');

use EkAndreas\DockerBedrock\Machine;
use EkAndreas\DockerBedrock\Mysql;
use EkAndreas\DockerBedrock\Web;
use EkAndreas\DockerBedrock\Elasticsearch;
use EkAndreas\DockerBedrock\Env;

task('docker:start', function () {
    
    Env::ensure('docker');

    $machine = new Machine();
    $machine->ensure();

    $mysql_name = env('container') . '_mysql';
    $mysql = new Mysql($mysql_name);
    $mysql->ensure();

    $elastic_name = env('container') . '_elastic';
    $elastic = new Elasticsearch($elastic_name);
    $elastic->ensure();

    $web_name = basename(Helpers::getProjectDir());
    $web = new Web($web_name);
    $web->ensure();

}, 999);

task('docker:up', function () {
    
    Env::ensure('docker');

    $machine = new Machine();
    $machine->ensure();

    $mysql_name = env('container') . '_mysql';
    $mysql = new Mysql($mysql_name);
    $mysql->ensure();

    $elastic_name = env('container') . '_elastic';
    $elastic = new Elasticsearch($elastic_name);
    $elastic->ensure();

    $web_name = basename(Helpers::getProjectDir());
    $web = new Web($web_name);
    $web->ensure();

}, 999);

task('docker:stop', function () {
    
    Env::ensure('docker');

    $mysql_name = env('container') . '_mysql';
    $mysql = new Mysql($mysql_name);
    $mysql->stop();

    $elastic_name = env('container') . '_elastic';
    $elastic = new Elasticsearch($elastic_name);
    $elastic->stop();

    $web_name = basename(Helpers::getProjectDir());
    $web = new Web($web_name);
    $web->stop();

});

task('docker:halt', function () {
    
    Env::ensure('docker');

    $mysql_name = env('container') . '_mysql';
    $mysql = new Mysql($mysql_name);
    $mysql->stop();

    $elastic_name = env('container') . '_elastic';
    $elastic = new Elasticsearch($elastic_name);
    $elastic->stop();

    $web_name = basename(Helpers::getProjectDir());
    $web = new Web($web_name);
    $web->stop();

});

task('docker:kill', function () {
    
    Env::ensure('docker');

    $mysql_name = env('container') . '_mysql';
    $mysql = new Mysql($mysql_name);
    $mysql->kill();

    $elastic_name = env('container') . '_elastic';
    $elastic = new Elasticsearch($elastic_name);
    $elastic->kill();

    $web_name = basename(Helpers::getProjectDir());
    $web = new Web($web_name);
    $web->kill();

});
