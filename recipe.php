<?php
include_once 'parameters.php';
include_once 'tasks.php';

if(!interface_exists('EkAndreas\DockerBedrock\ServiceInterface')) include_once 'src/DockerBedrock/ServiceInterface.php';
if(!class_exists('EkAndreas\DockerBedrock\Helpers')) include_once 'src/DockerBedrock/Helpers.php';
if(!class_exists('EkAndreas\DockerBedrock\Env')) include_once 'src/DockerBedrock/Env.php';
if(!class_exists('EkAndreas\DockerBedrock\Machine')) include_once 'src/DockerBedrock/Machine.php';
if(!class_exists('EkAndreas\DockerBedrock\Mysql')) include_once 'src/DockerBedrock/Mysql.php';
if(!class_exists('EkAndreas\DockerBedrock\Web')) include_once 'src/DockerBedrock/Web.php';
