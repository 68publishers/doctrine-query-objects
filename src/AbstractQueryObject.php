<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects;

use SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface;

abstract class AbstractQueryObject implements QueryObjectInterface
{
	/**
	 * Implementation of this method is optional
	 *
	 * {@inheritDoc}
	 */
	public function createCountQuery(QueryFactoryInterface $queryFactory)
	{
		return NULL;
	}
}
