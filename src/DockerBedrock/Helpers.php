<?php

namespace EkAndreas\DockerBedrock;

class Helpers
{
    static function start() {
        $machine = new Machine();
        $machine->ensure();

        $mysql_name = get('docker.container') . '_mysql';
        $mysql = new Mysql($mysql_name);
        $mysql->ensure();

        $elastic_name = get('docker.container') . '_elastic';
        $elastic = new Elasticsearch($elastic_name);
        $elastic->ensure();

        $web_name = basename(EkAndreas\DockerBedrock\Helpers::getProjectDir()).'_web';
        $web = new Web($web_name);
        $web->ensure();
    }

    static function stop() {
        $mysql_name = get('docker.container') . '_mysql';
        $mysql = new Mysql($mysql_name);
        $mysql->stop();

        $elastic_name = get('docker.container') . '_elastic';
        $elastic = new Elasticsearch($elastic_name);
        $elastic->stop();

        $web_name = basename(EkAndreas\DockerBedrock\Helpers::getProjectDir()).'_web';
        $web = new Web($web_name);
        $web->stop();
    }

    static function kill() {
        $mysql_name = get('docker.container') . '_mysql';
        $mysql = new Mysql($mysql_name);
        $mysql->kill();

        $elastic_name = get('docker.container') . '_elastic';
        $elastic = new Elasticsearch($elastic_name);
        $elastic->kill();

        $web_name = basename(EkAndreas\DockerBedrock\Helpers::getProjectDir()).'_web';
        $web = new Web($web_name);
        $web->kill();
    }

    static public function waitForPort($waiting_message, $ip, $port)
    {
        write($waiting_message);
        while (!Helpers::portAlive($ip, $port)) {
            sleep(1);
            write('.');
        }
        writeln("<fg=green>Up!</fg=green> Connect at <fg=yellow>=> $ip:$port</fg=yellow>");
    }

    static public function portAlive($ip, $port)
    {
        $result = false;
        try {
            if( @fsockopen($ip, $port, $errno, $errstr, 5) ) {
                $result = true;
            }
        } catch (Exception $ex) {
            $result = false;
        }
        return $result;
    }

    static function getMachineIp() {

        $result = '';

        if( has('docker.machine.ip') ) {
            $result = get('docker.machine.ip');
            return $result;
        }
        else {
            $docker_name = env('server.host');
            writeln("Getting environment data from $docker_name");
            $output = runLocally("docker-machine env $docker_name");
            if( preg_match('#DOCKER_HOST\=\"tcp:\/\/(.*):#i', $output, $matches) ) {
                $result = $matches[1];
            }
            set('docker.machine.ip',$result);
            return $result;
        }

    }

    static function getPackageDir() {
        $dir = realpath(__DIR__.'/../../');
        return $dir;
    }

    static function getProjectDir() {
        $dir = Helpers::getPackageDir();
        $web_dir = realpath("$dir/../../../");
        return $web_dir;
    }

    static function doLocal($command, $timeout=999) {
        writeln('===================================================');
        writeln('Running command:');
        writeln($command);
        writeln('===================================================');
        return runLocally(Env::evalDocker() . $command, $timeout);
    }

}
