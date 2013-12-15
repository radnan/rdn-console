Basic Usage
===========

## How to install

### 1. Require package

Use [composer](http://getcomposer.org) to require the `radnan/rdn-console` package:

~~~bash
$ composer require radnan/rdn-console:1.*
~~~

### 2. Activate module

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

### 1. `bin/console`

You must use the `vendor/bin/console` utility to run your commands. This utility might be in a different directory depending on your composer's `bin-dir` configuration.

~~~bash
$ vendor/bin/console
RdnConsole version 1.0.0

Usage:
  [options] command [arguments]

Options:
  --help           -h Display this help message.
  --quiet          -q Do not output any message.
  --verbose        -v|vv|vvv Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug
  --version        -V Display this application version.
  --ansi              Force ANSI output.
  --no-ansi           Disable ANSI output.
  --no-interaction -n Do not ask any interactive question.

Available commands:
  help                      Displays help for a command
  list                      Lists commands
~~~

### 2. `public/index.php`

The module will also take over all ZF2 console routes. So, you can use your ZF2 front controller to run your commands as well:

~~~bash
$ php public/index.php
~~~

## How to create commands

There are 2 steps involved in creating commands:

1. Create your command and register it with the `RdnConsole\Command\CommandManager` service locator
3. Inject the command into the `RdnConsole\Application` service

### 1. Console command service locator

Please read the [Console Command Service Locator](02-console-commands.md) documentation.

### 2. Console application

Please read the [Configuration](01-config.md) documentation.

## Interfaces

The following interfaces are available in the module:

* `RdnConsole\Command\CommandInterface`
	* `RdnConsole\Command\ConfigurableInterface`
	* `RdnConsole\Command\InitializableInterface`
	* `RdnConsole\Command\InteractableInterface`
	* `RdnConsole\Command\ExecutableInterface`

The `AbstractCommand` class implements all these interfaces except for `ConfigurableInterface`.

The `AbstractCommandFactory` class implements all these interfaces.

If you'd like to create your own command class which doesn't extend any of the provided abstract classes you must implement some or all of these classes.
