<?php

namespace EkAndreas;

use Composer\Installer\PackageEvent;

class Installer
{
    public static function postInstall(Event $event)
    {
        $vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
        $projectDir = realpath($vendorDir.'/../');
        $deployContent = file_get_contents(realpath(__DIR__.'/../config/deploy.php'));
        $deployContent = str_replace('the_project.dev', '', $deployContent);

        if( !file_exists(projectDir.'/deploy.dep')) {

	        $deployContent = str_replace(
	        	['the_project.dev','TIMEZONE'],
	        	[basename($projectDir).'.dev',date_default_timezone_get()],
	        	$deployContent
	        );

        	echo 'Adding deploy.php in project root';
			file_put_contents($projectDir.'/deploy.php', $deployContent);
        }
        
    }

}
