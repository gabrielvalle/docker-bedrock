<?php

namespace EkAndreas;

use Composer\Installer\PackageEvent;

class Installer
{
    public static function postUpdate(PackageEvent $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $projectDir = realpath($vendorDir.'/../');
        $installedPackage = $event->getOperation()->getPackage();
        $deployContent = file_get_contents(realpath(__DIR__.'/../config/deploy.php'));
        $deployContent = str_replace('the_project.dev', '', $deployContent);
        file_put_contents($projectDir.'/deploy.php', $deployContent);
    }

}
