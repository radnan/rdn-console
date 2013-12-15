<?php

namespace RdnConsole\Command;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\Exception;

class CommandManager extends AbstractPluginManager
{
	/**
	 * Validate the plugin
	 *
	 * Checks that the plugin loaded is an instance of CommandInterface.
	 *
	 * @param  mixed $plugin
	 * @return void
	 * @throws Exception\RuntimeException if invalid
	 */
	public function validatePlugin($plugin)
	{
		if ($plugin instanceof CommandInterface)
		{
			return;
		}

		throw new Exception\RuntimeException(sprintf(
			'Plugin of type %s is invalid; must implement %s\CommandInterface'
			, is_object($plugin) ? get_class($plugin) : gettype($plugin)
			, __NAMESPACE__
		));
	}
}
