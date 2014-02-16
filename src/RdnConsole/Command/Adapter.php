<?php

namespace RdnConsole\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Adapter extends Command implements AdapterInterface
{
	protected $command;

	public function __construct(CommandInterface $command)
	{
		$this->setCommand($command);

		parent::__construct();
	}

	public function setCommand(CommandInterface $command)
	{
		$this->command = $command;
		$this->command->setAdapter($this);
	}

	public function getCommand()
	{
		return $this->command;
	}

	protected function configure()
	{
		if (!$this->command instanceof ConfigurableInterface)
		{
			throw new \RuntimeException(sprintf(
				'Command (%s) must implement %s\ConfigurableInterface'
				, get_class($this->command)
				, __NAMESPACE__
			));
		}

		$this->command->configure();
	}

	protected function initialize(InputInterface $input, OutputInterface $output)
	{
		if ($this->command instanceof InitializableInterface)
		{
			$this->command->initialize($input, $output);
		}
	}

	protected function interact(InputInterface $input, OutputInterface $output)
	{
		if ($this->command instanceof InteractableInterface)
		{
			$this->command->interact($input, $output);
		}
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if ($this->command instanceof ExecutableInterface)
		{
			$this->command->execute($input, $output);
		}
	}
}
