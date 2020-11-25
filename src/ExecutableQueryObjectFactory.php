<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects;

use SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface;

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
	public function create(QueryObjectInterface $queryObject, ?ResultSetOptionsInterface $resultSetOptions = NULL): ExecutableQueryObjectInterface
	{
		return new ExecutableQueryObject($queryObject, $this->queryFactory, $resultSetOptions);
	}
}
