<?php
namespace EkAndreas\DockerBedrock;

class Mysql extends Container implements ContainerInterface
{
    public function ensure()
    {
        $ping = Helpers::portAlive($this->ip, 3306);

        if (!$ping) {
            if ($this->exists()) {
                $this->start();
            } else {
                $this->run();
            }
        }
    }

    public function exists()
    {
        $command = Env::get() . "docker inspect $this->container";
        try {
            $output = runLocally($command);
            return true;
        } catch (\Exception $ex) {
            return false;
        }
    }

    public function run()
    {
        writeln("<comment>Run/new mysql container $this->container</comment>");

        $env = Env::getDotEnv();
        $db = getenv('DB_NAME');
        $password = getenv('DB_PASSWORD');
        $user = getenv('DB_USER');

        $version = get('mysql.version');
        $command = Env::get() . "docker run --name $this->container ";
        $command .= "-e MYSQL_ROOT_PASSWORD=$password ";
        $command .= "-e MYSQL_DATABASE=$db ";
        if ($user!='root') {
            $command .= "-e MYSQL_USER=$user ";
            $command .= "-e MYSQL_PASSWORD=$password ";
        }
        $command .= "-p 3306:3306 -d mysql:$version";
        runLocally($command);
        Helpers::waitForPort('Waiting for mysql to start', $this->ip, 3306);
    }

    public function start()
    {
        writeln("<comment>Start existing mysql $this->container</comment>");
        $command = Env::get() . "docker start $this->container";
        runLocally($command);
        Helpers::waitForPort('Waiting for mysql to start', $this->ip, 3306);
    }

    public function stop()
    {
        writeln("<comment>Stop running mysql $this->container</comment>");
        $command = Env::get() . "docker stop $this->container";
        runLocally($command);
    }
    
    public function kill()
    {
        if( $this->exists() ) {
            writeln("<comment>Kill Mysql container $this->container</comment>");
            $command = Env::get() . "docker rm -f $this->container";
            runLocally($command);
        }
    }
}
