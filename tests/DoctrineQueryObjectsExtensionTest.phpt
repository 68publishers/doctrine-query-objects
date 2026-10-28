<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Tests;

use Tester\Assert;
use Nette\DI\Compiler;
use Nette\DI\ContainerLoader;
use Doctrine\ORM\EntityManagerInterface;
use SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures\ArticlesQuery;
use SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures\EntityManagerFactory;
use SixtyEightPublishers\DoctrineQueryObjects\ExecutableQueryObjectFactoryInterface;
use SixtyEightPublishers\DoctrineQueryObjects\Bridge\Nette\DI\DoctrineQueryObjectsExtension;

require __DIR__ . '/bootstrap.php';

$loader = new ContainerLoader(TEMP_PATH . '/di', TRUE);
$class = $loader->load(static function (Compiler $compiler): void {
	$compiler->addExtension('doctrine_query_objects', new DoctrineQueryObjectsExtension());
	$compiler->addConfig([
		'services' => [
			'em' => [
				'type' => EntityManagerInterface::class,
				'imported' => TRUE,
			],
		],
	]);
}, __FILE__);

$container = new $class();
$container->addService('em', EntityManagerFactory::create());

$factory = $container->getByType(ExecutableQueryObjectFactoryInterface::class);

Assert::type(ExecutableQueryObjectFactoryInterface::class, $factory);
Assert::same(5, $factory->create(new ArticlesQuery())->count());
