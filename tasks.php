<?php

task('docker:start', function () {
    Helpers::start();    
}, 999);

task('docker:up', function () {
    Helpers::start();    
}, 999);

task('docker:stop', function () {
    Helpers::stop();    
});

task('docker:halt', function () {
    Helpers::stop();    
});

task('docker:kill', function () {
    Helpers::kill();    
});
