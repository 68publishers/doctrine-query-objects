<?php

declare(strict_types=1);

if (@!include __DIR__ . '/../vendor/autoload.php') {
	echo 'Please run `composer install`';
	exit(1);
}

Tester\Environment::setup();

if (!defined('TEMP_PATH')) {
	define('TEMP_PATH', __DIR__ . '/temp');
}

if (!defined('CONFIG_DIR')) {
	define('CONFIG_DIR', __DIR__ . '/config');
}

# The lowest versions of some third-party dependencies trigger deprecations on newer PHP versions (used by CI only)
if (getenv('TESTS_IGNORE_DEPRECATIONS')) {
	error_reporting(E_ALL & ~E_DEPRECATED);
}
