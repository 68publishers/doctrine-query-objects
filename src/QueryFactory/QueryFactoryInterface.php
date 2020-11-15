<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\QueryFactory;

use Doctrine\ORM\Query;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Query\ResultSetMapping;

interface QueryFactoryInterface
{
	/**
	 * @param string $dql
	 *
	 * @return \Doctrine\ORM\Query
	 */
	public function createQuery(string $dql = ''): Query;

	/**
	 * @param string                               $sql
	 * @param \Doctrine\ORM\Query\ResultSetMapping $rsm
	 *
	 * @return \Doctrine\ORM\NativeQuery
	 */
	public function createNativeQuery(string $sql, ResultSetMapping $rsm): NativeQuery;

	/**
	 * @return \Doctrine\ORM\QueryBuilder
	 */
	public function createQueryBuilder(): QueryBuilder;
}
