<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects;

use SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface;

interface QueryObjectInterface
{
	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface $queryFactory
	 *
	 * @return \Doctrine\ORM\AbstractQuery|\Doctrine\ORM\QueryBuilder
	 */
	public function createQuery(QueryFactoryInterface $queryFactory);

	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface $queryFactory
	 *
	 * @return \Doctrine\ORM\AbstractQuery|\Doctrine\ORM\QueryBuilder|NULL
	 */
	public function createCountQuery(QueryFactoryInterface $queryFactory);
}
