Console Command Service Locator
===============================

The `RdnConsole\Command\CommandManager` service locator contains all of our console commands. Commands are any class that implements the `RdnConsole\Command\CommandInterface` interface.

## Configuration

The `rdn_console_commands` configuration option is used to configure this service locator.

~~~php
<?php

return array(
	'rdn_console_commands' => array(
		'factories' => array(),
		'invokables' => array(),
	),
);
~~~

If a command does not have any external dependency, then you should register it as an invokable. Otherwise configure it as a factory.

## Commands

The `RdnConsole\Command\AbstractCommand` abstract class is included with the module for your convenience. Simply extend this class when creating your commands.

~~~php
<?php

namespace App\Console\Command;

use RdnConsole\Command\AbstractCommand;
use RdnConsole\Command\ConfigurableInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorld extends AbstractCommand implements ConfigurableInterface
{
	public function configure()
	{
		$this->adapter
			->setName('app:hello-world')
			->setDescription('Test hello world command')
		;
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('Hello world!');
	}
}
~~~

Notice you must implement the `RdnConsole\Command\ConfigurableInterface` interface if this class also provides its own configuration. You don't need to do this if there is a factory for this command that provides the configuration.

### Adapter

The module uses an adapter to connect the command to the Symfony console application. You must use this adapter when interacting with the application:

~~~php
class HelloWorld extends AbstractCommand
{
	public function configure()
	{
		$this->adapter
			->setName('app:hello-world')
			->setDescription('Test hello world command')
		;
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$dialog = $this->adapter->getHelperSet()->get('dialog');
		$output->writeln('Hello world!');
	}
}
~~~

By default `RdnConsole\Command\Adapter` is used as the adapter but this can be easily customized by overriding the `getAdapter()` method in your command or command factory:

~~~php
class HelloWorld extends AbstractCommand
{
	public function getAdapter()
	{
		if (!$this->adapter)
		{
			$this->adapter = new MyCustomAdapter($this);
		}

		return $this->adapter;
	}
}
~~~

You can extend your `MyCustomAdapter` class from the default adapter class. Or you can make a completely custom one, in which case just make sure `MyCustomAdapter` extends the Symfony command class (`Symfony\Component\Console\Command\Command`) and implements the adapter interface (`RdnConsole\Command\AdapterInterface`).

## Factories

Factories are useful when a command has external dependencies. The command will contain the execution code, while the factory will contain the configuration and the code used to generate the command.

The `RdnConsole\Factory\Command\AbstractCommandFactory` abstract class is included with the module for your convenience. Simply extend this class when creating your command factory. This class extends the `AbstractFactory` class from the [rdn-factory](https://github.com/radnan/rdn-factory) module.

~~~php
<?php

namespace App\Factory\Console\Command;

use App\Console\Command;
use RdnConsole\Factory\Command\AbstractCommandFactory;

class HelloWorld extends AbstractCommandFactory
{
	public function configure()
	{
		$this->adapter
			->setName('app:hello-world')
			->setDescription('Test hello world command')
		;
	}

	protected function create()
	{
		$dependency = $this->service('External dependency');
		return new Command\HelloWorld($dependency);
	}
}
~~~

Then, in our command class we would only have the execution code:

~~~php
<?php

namespace App\Console\Command;

use RdnConsole\Command\AbstractCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloWorld extends AbstractCommand
{
	protected $dependency;

	public function __construct($dependency)
	{
		$this->dependency = $dependency;
	}

	public function execute(InputInterface $input, OutputInterface $output)
	{
		$output->writeln('Hello world!');
	}
}
~~~
