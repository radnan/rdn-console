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
		$config = $this->config('rdn_console', 'config', 'cache_clear');
		return new Command\CacheClear($config);
	}
}
