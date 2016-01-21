<?php

namespace EkAndreas\DockerBedrock;

interface ServiceInterface {

    public static function ensure();
    public static function exists();
    public static function run();
    public static function start();
    public static function stop();
    public static function kill();

}