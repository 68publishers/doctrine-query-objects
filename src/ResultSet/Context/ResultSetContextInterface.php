<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context;

use Iterator;
use Doctrine\ORM\AbstractQuery;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Lock;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface;

interface ResultSetContextInterface
{
	/**
	 * @return \Doctrine\ORM\AbstractQuery
	 */
	public function getQuery(): AbstractQuery;

	/**
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Lock
	 */
	public function getLock(): Lock;

	/**
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface
	 */
	public function getOptions(): ResultSetOptionsInterface;

	/**
	 * @return \Iterator|NULL
	 */
	public function getIterator(): ?Iterator;

	/**
	 * @param \Iterator|NULL $iterator
	 *
	 * @return void
	 */
	public function setIterator(?Iterator $iterator): void;
}
