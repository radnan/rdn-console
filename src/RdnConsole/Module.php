<?php

namespace RdnConsole;

use Zend\ModuleManager\ModuleManager;

class Module
{
	public function getConfig()
	{
		return include __DIR__ .'/../../config/module.config.php';
	}

	public function init(ModuleManager $modules)
	{
		$modules->loadModule('RdnFactory');
	}
}
