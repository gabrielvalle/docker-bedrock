<?php
namespace EkAndreas\DockerBedrock;

class Elasticsearch extends Container implements ContainerInterface
{
    public function ensure()
    {
        $ping = Helpers::portAlive($this->ip, 9200);

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
        writeln("<comment>Run/new elasticsearch container $this->container</comment>");
        $command = Env::get() . "docker run --name $this->container -d -p 9200:9200 elasticsearch";
        runLocally($command);
        Helpers::waitForPort('Waiting for elasticsearch to start', $this->ip, 9200);
    }

    public function start()
    {
        writeln("<comment>Start existing elasticsearch container $this->container</comment>");
        $command = Env::get() . "docker start $this->container";
        runLocally($command);
        Helpers::waitForPort('Waiting for elasticsearch to start', $this->ip, 9200);
    }

    public function stop()
    {
        writeln("<comment>Stop running elasticsearch $this->container</comment>");
        $command = Env::get() . "docker stop $this->container";
        runLocally($command);
    }
    
    public function kill()
    {
        if( $this->exists() ) {
            writeln("<comment>Kill elasticsearch container $this->container</comment>");
            $command = Env::get() . "docker rm -f $this->container";
            runLocally($command);
        }
    }
}
