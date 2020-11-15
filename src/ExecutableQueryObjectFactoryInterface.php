<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects;

use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptions;

interface ExecutableQueryObjectFactoryInterface
{
	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\QueryObjectInterface            $queryObject
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptions|null $resultSetOptions
	 *
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ExecutableQueryObjectInterface
	 */
	public function create(QueryObjectInterface $queryObject, ?ResultSetOptions $resultSetOptions = NULL): ExecutableQueryObjectInterface;
}
