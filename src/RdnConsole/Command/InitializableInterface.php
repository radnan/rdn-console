<?php

namespace RdnConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

interface InitializableInterface extends CommandInterface
{
	public function initialize(InputInterface $input, OutputInterface $output);
}
