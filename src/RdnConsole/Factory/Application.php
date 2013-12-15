<?php

namespace RdnConsole\Factory;

use RdnConsole\Command;
use Symfony\Component\Console;
use Symfony\Component\Console\Input\InputOption;
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
				$command = new Command\Adapter($commands->get($name));
				$app->add($command);
			}
		}

		return $app;
	}
}
