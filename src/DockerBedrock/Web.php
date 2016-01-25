<?php
namespace EkAndreas\DockerBedrock;

class Web extends Container implements ContainerInterface
{
    public function ensure()
    {
        $ping = Helpers::portAlive($this->ip, 80);

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
        $command = Env::get() . "docker ps -a";
        $output = runLocally($command);

        if (preg_match('/'.$this->container.'/i', $output, $matches)) {
            return true;
        } else {
            return false;
        }
    }

    public function run()
    {
        writeln('<comment>New web container ' . $this->container . '</comment>');

        $command = Env::get() . "cd {$this->dir} && docker images";
        $output = runLocally($command);

        $matches=null;
        if (!preg_match('/'.$this->image.'\s.*latest\s*([[:alnum:]]+).*/i', $output, $matches)) {

            // shift Dockerfile?
            if (file_exists(Helpers::getProjectDir().'/Dockerfile')) {
                copy(Helpers::getProjectDir().'/Dockerfile',Helpers::getPackageDir().'/Dockerfile');
            }
                     
            // shift php.ini?
            if (file_exists(Helpers::getProjectDir().'/config/php.ini')) {
                copy(Helpers::getProjectDir().'/config/php.ini',Helpers::getPackageDir().'/config/php.ini');
            }
                     
            writeln('<comment>Building web image ' . $this->image . '</comment>');
            $command = Env::get() . "cd {$this->dir} && docker build -t {$this->image} --no-cache=true --rm=true .";
            runLocally($command, 999);
            preg_match('/'.$this->image.'\s.*latest\s*([[:alnum:]]+).*/i', $output, $matches);
        }

        writeln('<comment>Starting new web container ' . $this->container . '</comment>');
        $command = Env::get() . "cd $this->dir && docker run -tid -p 80:80 -v '$this->webdir:/var/www/html' --name $this->container $this->image:latest";
        runLocally($command, 999);
        Helpers::waitForPort('Waiting for web to start', $this->ip, 80);
    }

    public function start()
    {
        writeln('<comment>Start existing web container</comment>');
        $command = Env::get() . "cd $this->dir && docker start $this->container";
        runLocally($command);
        Helpers::waitForPort('Waiting for web to start', $this->ip, 80);
    }

    public function stop()
    {
        writeln('<comment>Stop running web</comment>');
        $command = Env::get() . "docker stop $this->container";
        runLocally($command);
    }
    
    public function kill()
    {
        if( $this->exists() ) {
            writeln('<comment>Kill web container</comment>');
            $command = Env::get() . "docker rm -f $this->container";
            runLocally($command);
        }

        $command = Env::get() . "cd {$this->dir} && docker images";
        $output = runLocally($command);
        if (preg_match('/'.$this->image.'\s.*latest\s*([[:alnum:]]+).*/i', $output, $matches)) {
            $command = Env::get() . "cd {$this->dir} && docker rmi $this->image";
            runLocally($command);
        }

    }
}
