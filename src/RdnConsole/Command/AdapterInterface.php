<?php

namespace RdnConsole\Command;

interface AdapterInterface
{
	public function setCommand(CommandInterface $command);

	/**
	 * @return CommandInterface
	 */
	public function getCommand();
}
