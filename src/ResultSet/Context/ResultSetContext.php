<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context;

use Iterator;
use Doctrine\ORM\AbstractQuery;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Lock;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface;

final class ResultSetContext implements ResultSetContextInterface
{
	/** @var \Doctrine\ORM\AbstractQuery  */
	private $query;

	/** @var \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Lock  */
	private $lock;

	/** @var \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface  */
	private $resultSetOptions;

	/** @var \Iterator|NULL */
	private $iterator;

	/**
	 * @param \Doctrine\ORM\AbstractQuery                                                    $query
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Lock                      $lock
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface $resultSetOptions
	 */
	public function __construct(AbstractQuery $query, Lock $lock, ResultSetOptionsInterface $resultSetOptions)
	{
		$this->query = $query;
		$this->lock = $lock;
		$this->resultSetOptions = $resultSetOptions;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getQuery(): AbstractQuery
	{
		return $this->query;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getLock(): Lock
	{
		return $this->lock;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getOptions(): ResultSetOptionsInterface
	{
		return $this->resultSetOptions;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIterator(): ?Iterator
	{
		return $this->iterator;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setIterator(?Iterator $iterator): void
	{
		$this->iterator = $iterator;
	}
}
