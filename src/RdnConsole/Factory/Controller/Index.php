<?php

namespace RdnConsole\Factory\Controller;

use RdnConsole\Controller;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class Index implements FactoryInterface
{
	/**
	 * Create service
	 *
	 * @param ServiceLocatorInterface $controllers
	 * @return Controller\Index
	 */
	public function createService(ServiceLocatorInterface $controllers)
	{
		if ($controllers instanceof ServiceLocatorAwareInterface)
		{
			$services = $controllers->getServiceLocator();
		}
		else
		{
			$services = $controllers;
		}

		return new Controller\Index($services->get('RdnConsole\Application'));
	}
}
