<?php

return array(
	'console' => array(
		'router' => array(
			'routes' => array(
				'rdn-console' => array(
					'type' => 'catchall',
					'options' => array(
						'defaults' => array(
							'controller' => 'RdnConsole:Index',
							'action' => 'index',
						),
					),
				),
			),
		),
	),

	'controllers' => array(
		'factories' => array(
			'RdnConsole:Index' => 'RdnConsole\Factory\Controller\Index',
		),
	),

	'rdn_console' => array(
		'application' => array(
			'name' => 'RdnConsole',
			'version' => '1.2.0',
		),

		'commands' => array(
			//'RdnConsole:CacheClear',
		),

		'config' => array(
			'cache_clear' => array(
				'directory' => 'data/cache',
			),
		),
	),

	'rdn_console_commands' => array(
		'factories' => array(
			'RdnConsole:CacheClear' => 'RdnConsole\Factory\Command\CacheClear',
		),
	),

	'service_manager' => array(
		'factories' => array(
			'RdnConsole\Application' => 'RdnConsole\Factory\Application',
			'RdnConsole\Command\CommandManager' => 'RdnConsole\Factory\Command\CommandManager',
		),
	),
);
