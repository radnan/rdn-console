<?php

namespace RdnConsole\Factory;

use RdnConsole\Command\CommandInterface;
use Symfony\Component\Console;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Application implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $services
	 * @return Console\Application
	 */
	public function createService(ServiceLocatorInterface $services)
	{
		$app = new Console\Application;

		$config = $services->get('Config');
		$config = $config['rdn_console'];

		if (isset($config['application']['name']))
		{
			$app->setName($config['application']['name']);
		}
		if (isset($config['application']['version']))
		{
			$app->setVersion($config['application']['version']);
		}

		if (!empty($config['commands']))
		{
			$commands = $services->get('RdnConsole\Command\CommandManager');
			foreach ($config['commands'] as $name)
			{
				/** @var CommandInterface $command */
				$command = $commands->get($name);
				$app->add($command->getAdapter());
			}
		}

		return $app;
	}
}
