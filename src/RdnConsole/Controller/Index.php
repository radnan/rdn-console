<?php

namespace RdnConsole\Controller;

use Symfony\Component\Console\Application;
use Zend\Mvc\Controller\AbstractActionController;

class Index extends AbstractActionController
{
	protected $console;

	public function __construct(Application $console)
	{
		$this->console = $console;
	}

	public function indexAction()
	{
		$this->console->run();
	}
}
