<?php

namespace RdnConsole\Command;

interface ConfigurableInterface extends CommandInterface
{
	public function configure();
}
