<?php

namespace EkAndreas\DockerBedrock;

class Env {

	static function get() {
        $docker_name = get('docker.machine.name');
	    return 'eval "$(docker-machine env ' . $docker_name . ')" && ';
	}

	/**
	 * @return Dotenv\Dotenv Bedrock Settings
	 */
	static function getDotEnv() {
		$dotenv = new \Dotenv\Dotenv(Helpers::getProjectDir());
		$dotenv->load();
		$dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD']);
		return $dotenv;
	}

}