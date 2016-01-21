<?php

task('docker:start', function() {
	
	EkAndreas\DockerBedrock\Machine::ensure();
	EkAndreas\DockerBedrock\Mysql::ensure();
	EkAndreas\DockerBedrock\Web::ensure();

},999);

task('docker:up', function() {
	
	EkAndreas\DockerBedrock\Machine::ensure();
	EkAndreas\DockerBedrock\Mysql::ensure();
	EkAndreas\DockerBedrock\Web::ensure();

},999);

task('docker:stop', function() {
	
	EkAndreas\DockerBedrock\Mysql::stop();
	EkAndreas\DockerBedrock\Web::stop();

});

task('docker:halt', function() {
	
	EkAndreas\DockerBedrock\Mysql::stop();
	EkAndreas\DockerBedrock\Web::stop();

});

