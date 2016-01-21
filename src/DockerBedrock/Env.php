<?php

namespace EkAndreas\DockerBedrock;

class Env {

	static function get() {
        $docker_name = get('docker.machine.name');
	    return 'eval "$(docker-machine env ' . $docker_name . ')" && ';
	}

}