<?php

namespace EkAndreas\DockerBedrock;

class Mysql implements ServiceInterface
{

    public static function ensure()
    {
        $ip = Helpers::getMachineIp();
        $ping = Helpers::portAlive($ip, 3306);

        if (!$ping) {
            if (Mysql::exists()) {
                Mysql::start();
            } else {
                Mysql::run();
            }
        }
    }

    public static function exists()
    {
        $name = get('docker.container') . '_mysql';
        $command = Env::get() . "docker inspect $name";

        try {
	        $output = runLocally($command);
            return true;
        } catch (\Exception $ex) {
            return false;
        }

    }

    public static function run()
    {
    	writeln('<comment>Run/new Mysql container</comment>');
        $ip = Helpers::getMachineIp();
        $name = get('docker.container') . '_mysql';
        $db = get('mysql.database');
        $password = get('mysql.password');
        $version = get('mysql.version');
        $command = Env::get() . "docker run --name $name -e MYSQL_ROOT_PASSWORD=$password -e MYSQL_DATABASE=$db -p 3306:3306 -d mysql:$version";
        runLocally($command);
        Helpers::waitForPort('Waiting for mysql to start', $ip, 3306);
    }

    public static function start()
    {
    	writeln('<comment>Start existing Mysql</comment>');
        $ip = Helpers::getMachineIp();
        $name = get('docker.container') . '_mysql';
        $command = Env::get() . "docker start $name";
        runLocally($command);
        Helpers::waitForPort('Waiting for mysql to start', $ip, 3306);
    }

    public static function stop()
    {
    	writeln('<comment>Stop running Mysql</comment>');
        $name = get('docker.container') . '_mysql';
        $command = Env::get() . "docker stop $name";
        runLocally($command);
    }
    
    public static function kill()
    {
    	writeln('<comment>Kill Mysql container</comment>');
        $name = get('docker.container') . '_mysql';
        $command = Env::get() . "docker rm -f $name";
        runLocally($command);
    }
}
