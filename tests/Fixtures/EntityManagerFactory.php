<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Mapping\Driver\StaticPHPDriver;

final class EntityManagerFactory
{
	/**
	 * Creates the in-memory SQLite database with articles #1 - #5, every article has two tags
	 */
	public static function create(): EntityManagerInterface
	{
		$config = new Configuration();
		$config->setMetadataDriverImpl(new StaticPHPDriver([__DIR__]));
		$config->setProxyDir(TEMP_PATH . '/proxies');
		$config->setProxyNamespace('SixtyEightPublishers\DoctrineQueryObjects\Tests\Proxies');
		$config->setAutoGenerateProxyClasses(TRUE);

		if (PHP_VERSION_ID >= 80400 && method_exists($config, 'enableNativeLazyObjects')) {
			$config->enableNativeLazyObjects(TRUE);
		}

		$connection = DriverManager::getConnection(['driver' => 'pdo_sqlite', 'memory' => TRUE]);
		$em = method_exists(EntityManager::class, 'create') ? EntityManager::create($connection, $config) : new EntityManager($connection, $config);

		(new SchemaTool($em))->createSchema([$em->getClassMetadata(Article::class), $em->getClassMetadata(Tag::class)]);

		for ($i = 1; $i <= 5; $i++) {
			$article = new Article($i, 'Article ' . $i);
			$em->persist($article);
			$em->persist(new Tag($i * 10 + 1, $article));
			$em->persist(new Tag($i * 10 + 2, $article));
		}

		$em->flush();
		$em->clear();

		return $em;
	}
}
