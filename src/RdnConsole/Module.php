<?php

namespace RdnConsole;

use Zend\ModuleManager\ModuleManager;

class Module
{
	public function getConfig()
	{
		return include $this->getPath() .'/config/module.config.php';
	}

	public function getPath()
	{
		return dirname(dirname(__DIR__));
	}

	public function init(ModuleManager $modules)
	{
		$modules->loadModule('RdnFactory');
	}
}
