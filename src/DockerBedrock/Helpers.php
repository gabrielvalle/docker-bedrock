<?php

namespace EkAndreas\DockerBedrock;

class Helpers
{
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
        return runLocally(Env::evalDocker() . $command, $timeout);
    }

}
