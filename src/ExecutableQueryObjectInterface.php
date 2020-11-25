<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects;

use Doctrine\ORM\Tools\Pagination\Paginator;

interface ExecutableQueryObjectInterface
{
	/**
	 * @param \Doctrine\ORM\Tools\Pagination\Paginator|null $paginator
	 *
	 * @return int
	 */
	public function count(?Paginator $paginator = NULL): int;

	/**
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetInterface|array
	 */
	public function fetch();

	/**
	 * @return object|NULL|mixed
	 */
	public function fetchOne(): ?object;
}
