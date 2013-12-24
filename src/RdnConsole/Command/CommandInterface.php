<?php

namespace RdnConsole\Command;

use Symfony\Component\Console\Command\Command;

interface CommandInterface
{
	public function setAdapter(AdapterInterface $adapter);

	/**
	 * @return AdapterInterface|Command
	 */
	public function getAdapter();
}
