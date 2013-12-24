<?php

namespace RdnConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractCommand implements
	InitializableInterface
	, InteractableInterface
	, ExecutableInterface
{
	/**
	 * @var Adapter
	 */
	protected $adapter;

	public function initialize(InputInterface $input, OutputInterface $output)
	{
	}

	public function interact(InputInterface $input, OutputInterface $output)
	{
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		throw new \LogicException('You must override the execute() method in the concrete command class.');
	}

	public function setAdapter(AdapterInterface $adapter)
	{
		$this->adapter = $adapter;
	}

	public function getAdapter()
	{
		if (!$this->adapter)
		{
			$this->adapter = new Adapter($this);
		}

		return $this->adapter;
	}
}
