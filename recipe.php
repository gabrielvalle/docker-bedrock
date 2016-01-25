<?php
if(!class_exists('EkAndreas\DockerBedrock\Helpers')) include_once 'src/DockerBedrock/Helpers.php';

$dir = EkAndreas\DockerBedrock\Helpers::getProjectDir();
require_once($dir . '/vendor/autoload.php');

include_once 'parameters.php';
include_once 'tasks.php';
