<?php

namespace RdnConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Zend\Stdlib\ErrorHandler;

class CacheClear extends AbstractCommand
{
	protected $config;

	public function __construct(array $config)
	{
		$this->config = $config;
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$cacheDir = $this->config['directory'];

		if (!is_writable($cacheDir))
		{
			throw new \RuntimeException("Unable to write to the $cacheDir directory");
		}

		$output->writeln('<info>Clearing the cache</info>');

		$dirIterator = new \RecursiveDirectoryIterator($cacheDir, \FilesystemIterator::SKIP_DOTS);
		/** @var \DirectoryIterator[] $items */
		$items = new \RecursiveIteratorIterator($dirIterator, \RecursiveIteratorIterator::CHILD_FIRST);
		foreach ($items as $item)
		{
			if (substr($item->getFileName(), 0, 1) == '.')
			{
				continue;
			}

			if ($item->isFile())
			{
				ErrorHandler::start();
				unlink($item->getPathName());
				ErrorHandler::stop(true);

				if (file_exists($item->getPathname()))
				{
					throw new \RuntimeException('Could not delete file '. $item->getPathname());
				}
			}
			else
			{
				ErrorHandler::start();
				rmdir($item->getPathName());
				ErrorHandler::stop(true);

				if (file_exists($item->getPathname()))
				{
					throw new \RuntimeException('Could not delete directory '. $item->getPathname());
				}
			}
		}

		$output->writeln('Successfully deleted all cache files');
	}
}
