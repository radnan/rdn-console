Configuration
=============

The `RdnConsole\Application` console application is configured using the `rdn_console` configuration option:

~~~php
<?php

return array(
	'rdn_console' => array(
		'application' => array(
			'name' => 'RdnConsole',
			'version' => '1.0.0',
		),

		'commands' => array(
			'RdnConsole:CacheClear',
		),
	),
);
~~~

The `name` and `version` options can be used to customize the application name and version.

The `commands` option is an array of command names that will be injected into the application after it's created. The commands are loaded from the [Console Command Service Locator](02-console-commands.md).
