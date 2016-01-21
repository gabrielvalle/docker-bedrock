<?php

namespace EkAndreas\DockerBedrock;

class Machine implements ServiceInterface
{

    public static function ensure()
    {
        $docker_name = get('docker.machine.name');
        writeln("Ensure docker-machine ".$docker_name);

        if (!Machine::exists()) {
            Machine::run();
        }

        $command = Env::get() . "docker-machine status $docker_name";
        $output = runLocally($command);

        if (!preg_match('#Running#i', $output, $matches)) {
            Machine::start();
        }
    }
    
    public static function run()
    {
        $docker_name = get('docker.machine.name');
        writeln("<comment>Create Docker machine $docker_name</comment>");
        $output = runLocally("docker-machine create -d virtualbox $docker_name");
        writeln("<comment>Docker-machine $docker_name created</comment>");
    }
    
    public static function kill()
    {
    }
    
    public static function exists()
    {
        $docker_name = get('docker.machine.name');
        $command = "docker-machine ls";
        $output = runLocally($command);
        if (preg_match('/'.$docker_name.'/i', $output, $matches)) {
            return true;
        } else {
        	return false;
        }
    }
    
    public static function start()
    {
        $docker_name = get('docker.machine.name');
        $output = runLocally("docker-machine start $docker_name");
        writeln("<comment>Starting docker-machine $docker_name, please wait...</comment>");
        sleep(20);
    }

    public static function stop()
    {
        $docker_name = get('docker.machine.name');
        try {
            writeln("Stop docker-machine ".$docker_name);
            $output = runLocally("docker-machine stop $docker_name");
            writeln("<comment>Docker-machine $docker_name stopped</comment>");
        } catch (Exception $ex) {
        }
    }
}
