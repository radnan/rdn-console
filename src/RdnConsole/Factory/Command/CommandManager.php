<?php

namespace RdnConsole\Factory\Command;

use RdnConsole\Command;
use Zend\ServiceManager\Config;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CommandManager implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $services
	 * @return Command\CommandManager
	 */
	public function createService(ServiceLocatorInterface $services)
	{
		$config = $services->get('Config');
		$config = new Config($config['rdn_console_commands']);

		$commands = new Command\CommandManager($config);
		$commands->setServiceLocator($services);

		return $commands;
	}
}
