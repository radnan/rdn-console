<?php

namespace RdnConsole\Factory\Command;

use RdnConsole\Command;
use RdnFactory\AbstractFactory;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractCommandFactory extends AbstractFactory implements
	Command\ConfigurableInterface
	, Command\InitializableInterface
	, Command\InteractableInterface
	, Command\ExecutableInterface
{
	/**
	 * @var Command\Adapter
	 */
	protected $adapter;

	protected $command;

	abstract public function configure();

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
}
