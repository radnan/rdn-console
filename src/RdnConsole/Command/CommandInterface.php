<?php

namespace RdnConsole\Command;

interface CommandInterface
{
	public function setAdapter(AdapterInterface $adapter);

	/**
	 * @return AdapterInterface
	 */
	public function getAdapter();
}
