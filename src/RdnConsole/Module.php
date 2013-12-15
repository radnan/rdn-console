<?php

namespace RdnConsole;

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
}
