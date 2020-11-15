<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects;

use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptions;
use SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface;

final class ExecutableQueryObjectFactory implements ExecutableQueryObjectFactoryInterface
{
	/** @var \SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface  */
	private $queryFactory;

	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface $queryFactory
	 */
	public function __construct(QueryFactoryInterface $queryFactory)
	{
		$this->queryFactory = $queryFactory;
	}

	/**
	 * {@inheritDoc}
	 */
	public function create(QueryObjectInterface $queryObject, ?ResultSetOptions $resultSetOptions = NULL): ExecutableQueryObjectInterface
	{
		return new ExecutableQueryObject($queryObject, $this->queryFactory, $resultSetOptions);
	}
}
