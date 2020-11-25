<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects;

use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface;

interface ExecutableQueryObjectFactoryInterface
{
	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\QueryObjectInterface                     $queryObject
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface|NULL $resultSetOptions
	 *
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ExecutableQueryObjectInterface
	 */
	public function create(QueryObjectInterface $queryObject, ?ResultSetOptionsInterface $resultSetOptions = NULL): ExecutableQueryObjectInterface;
}
