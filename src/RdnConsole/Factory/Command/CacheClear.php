<?php

namespace RdnConsole\Factory\Command;

use RdnConsole\Command;

class CacheClear extends AbstractCommandFactory
{
	public function configure()
	{
		$this->adapter
			->setName('rdn-console:cache-clear')
			->setDescription('Clear the cache directory')
		;
	}

	protected function create()
	{
		$config = $this->services->get('Config');
		$config = $config['rdn_console']['config']['cache_clear'];

		$command = new Command\CacheClear($config);
		return $command;
	}
}
