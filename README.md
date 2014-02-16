RdnConsole - Zend Framework Symfony Console Module
==================================================

The **RdnConsole** module bridges the Symfony Console component with Zend Framework 2.

## How to install

Use composer to require the `radnan/rdn-console` package:

~~~bash
$ composer require radnan/rdn-console:1.*
~~~

Activate the module by including it in your `application.config.php` file:

~~~php
<?php

return array(
	'modules' => array(
		'RdnConsole',
		// ...
	),
);
~~~

## How to use

You can use the `vendor/bin/console` utility to run your commands. This utility might be in a different directory depending on your composer's `bin-dir` configuration.

The module will also take over all zf2 console routes. So you can simply run `php public/index.php` to run your commands as well.

## How to create commands

Create your commands inside your module, register them with the console command service locator, and finally inject the command into the console application.

Let's create a hello world command inside our `App` module:

### 1. Create command class

Create the class `App\Console\Command\HelloWorld` by extending `RdnConsole\Command\AbstractCommand`:

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

### 2. Register command with service locator

Place the following in your `module.config.php` file (or in your module's `getConfig()` method):

~~~php
<?php

return array(
	'rdn_console_commands' => array(
		'invokables' => array(
			'App:HelloWorld' => 'App\Console\Command\HelloWorld',
		),
	),
);
~~~

### 3. Inject command into console application

Now, place the following in your `module.config.php` file:

~~~php
<?php

return array(
	'rdn_console' => array(
		'commands' => array(
			'App:HelloWorld',
		),
	),
);
~~~

### 4. Run the command!

Now you can simply run `vendor/bin/console app:hello-world` to run this command.

## Sample command

A sample `RdnConsole:CacheClear` command is provided with the module. You can enable it by including the following in your `module.config.php`:

~~~php
<?php

return array(
	'rdn_console' => array(
		'commands' => array(
			'RdnConsole:CacheClear',
		),
	),
);
~~~

## Command Adapter

You'll notice the command uses an adapter to configure itself:

~~~php
public function configure()
{
	$this->adapter
		->setName('app:hello-world')
		->setDescription('Test hello world command')
	;
}
~~~

This is slightly different from the default Symfony workflow. You must always use this adapter to talk with symfony: to get the command name, get helpers, etc.

We use the adapter in order to separate the configuration from the execution code. The benefits of this are explained in the next section.

## Factories

The best part about this module is that it allows us to separate a command's configuration from it's actual execution code.

What does this mean? Well, let's say you have a lot of commands, each with multiple dependencies. If we were to create our commands the default way, Symfony would load each command and all its dependencies every time.

But this is inefficient and slows down the application. Instead, this module will only load the initial configuration required to display the available list of commands.

Then when you are ready to actually execute the command, the module will use the factory pattern to create the command, load all its dependencies, and finally run the execution code.

### How to create commands using factories

#### 1. Create command class

Create your command class like you would normally, but don't implement the `ConfigurableInterface`. We also include any external dependencies:

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

#### 2. Create command factory

Next, we create the factory for this class by extending the `RdnConsole\Factory\Command\AbstractCommandFactory` class. This factory class will contain the command's configuration. You must also implement the `create()` method to create the actual command object:

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

The `AbstractCommandFactory` class extends the `AbstractFactory` class from the [rdn-factory](https://github.com/radnan/rdn-factory) module.

#### 3. Register command factory with service locator

Finally, we register this factory with the service locator replacing our previous invokable class:

~~~php
<?php

return array(
	'rdn_console_commands' => array(
		'factories' => array(
			'App:HelloWorld' => 'App\Factory\Console\Command\HelloWorld',
		),
	),
);
~~~
