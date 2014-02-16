<?php

namespace RdnConsole\Factory\Command;

use RdnConsole\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractCommandFactory implements
	FactoryInterface
	, Command\ConfigurableInterface
	, Command\InitializableInterface
	, Command\InteractableInterface
	, Command\ExecutableInterface
	, ServiceLocatorAwareInterface
{
	/**
	 * @var Command\Adapter
	 */
	protected $adapter;

	/**
	 * @var ServiceLocatorInterface
	 */
	protected $services;

	protected $command;

	abstract public function configure();

	abstract protected function create();

	public function getCommand()
	{
		if ($this->command === null)
		{
			$this->command = $this->create();
			if (!$this->command instanceof Command\CommandInterface)
			{
				throw new \InvalidArgumentException(sprintf(
					'Command (%s) must implement %s\CommandInterface'
					, get_class($this->command)
					, __NAMESPACE__
				));
			}
			$this->command->setAdapter($this->adapter);
		}
		return $this->command;
	}

	public function initialize(InputInterface $input, OutputInterface $output)
	{
		$command = $this->getCommand();
		if ($command instanceof Command\InitializableInterface)
		{
			$command->initialize($input, $output);
		}
	}

	public function interact(InputInterface $input, OutputInterface $output)
	{
		$command = $this->getCommand();
		if ($command instanceof Command\InteractableInterface)
		{
			$command->interact($input, $output);
		}
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$command = $this->getCommand();
		if ($command instanceof Command\ExecutableInterface)
		{
			$command->execute($input, $output);
		}
	}

	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $commands
	 * @return self
	 */
	public function createService(ServiceLocatorInterface $commands)
	{
		$this->setServiceLocator($commands);
		return $this;
	}

	public function setAdapter(Command\AdapterInterface $adapter)
	{
		$this->adapter = $adapter;
	}

	public function getAdapter()
	{
		if (!$this->adapter)
		{
			$this->adapter = new Command\Adapter($this);
		}

		return $this->adapter;
	}

	/**
	 * Set service locator
	 *
	 * @param ServiceLocatorInterface $services
	 */
	public function setServiceLocator(ServiceLocatorInterface $services)
	{
		if ($services instanceof ServiceLocatorAwareInterface)
		{
			$this->setServiceLocator($services->getServiceLocator());
			return;
		}

		$this->services = $services;
	}

	/**
	 * Get service locator
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->services;
	}
}
