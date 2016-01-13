<?php

namespace EkAndreas\DockerBedrock;

use Composer\Script\Event;
use Composer\Installer\PackageEvent;

class Install
{
    public static function postPackageInstall(PackageEvent $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $projectDir = realpath($vendorDir.'/../');
        $installedPackage = $event->getOperation()->getPackage();
        $deployContent = file_get_contents(realpath(__DIR__.'/../deploy.php'));
        $deployContent = str_replace('the_project.dev', '', $deployContent);
        file_put_contents($projectDir.'/deploy.php', $deployContent);
    }

}