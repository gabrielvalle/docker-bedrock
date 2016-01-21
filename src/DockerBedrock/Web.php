<?php

namespace EkAndreas\DockerBedrock;

class Web implements ServiceInterface
{

    public static function ensure()
    {
        $ip = Helpers::getMachineIp();
        $ping = Helpers::portAlive($ip, 80);

        if (!$ping) {
            if (Web::exists()) {
                Web::start();
            } else {
                Web::run();
            }
        }
    }

    public static function exists()
    {
        $name = Web::getContainerName();

        $command = Env::get() . "docker ps -a";
        $output = runLocally($command);

        if (preg_match('/'.$name.'/i', $output, $matches)) {
            return true;
        } else {
            return false;
        }
    }

    public static function run()
    {
        $ip = Helpers::getMachineIp();
        $name = get('docker.container') . '_web';
        $dir = Helpers::getPackageDir();
        $web_dir = Helpers::getProjectDir();

        writeln('<comment>New web container</comment>');

        $command = Env::get() . "cd $dir && docker images";
        $output = runLocally($command);

        $matches=null;

        if (!preg_match('/'.$name.'\s.*latest\s*([[:alnum:]]+).*/i', $output, $matches)) {
            writeln('<comment>Building web image</comment>');
            $command = Env::get() . "cd $dir && docker build -t {$name} --no-cache=true --rm=true .";
            runLocally($command);
            preg_match('/'.$name.'\s.*latest\s*([[:alnum:]]+).*/i', $output, $matches);
        }

        $container_name = Web::getContainerName();

        writeln('<comment>Starting new web container</comment>');
        $command = Env::get() . "cd $dir && docker run -tid -p 80:80 -v '$web_dir:/var/www/html' --name $container_name $name:latest";
        runLocally($command);
        Helpers::waitForPort('Waiting for web to start', $ip, 80);
    }

    public static function start()
    {
        $ip = Helpers::getMachineIp();
        $dir = Helpers::getPackageDir();
        $container_name = Web::getContainerName();

        writeln('<comment>Start existing web container</comment>');
        $command = Env::get() . "cd $dir && docker start $container_name";
        runLocally($command);
        Helpers::waitForPort('Waiting for web to start', $ip, 80);
    }

    public static function stop()
    {
        $name = Web::getContainerName();

        writeln('<comment>Stop running web</comment>');
        $command = Env::get() . "docker stop $name";
        runLocally($command);
    }
    
    public static function kill()
    {
        $name = Web::getContainerName();

        writeln('<comment>Kill web container</comment>');
        $command = Env::get() . "docker rm -f $name";
        runLocally($command);
    }

    public static function getContainerName()
    {
        $dir = Helpers::getPackageDir();
        $web_dir = Helpers::getProjectDir();

        $container_name = basename($web_dir);
        return $container_name;
    }
}
