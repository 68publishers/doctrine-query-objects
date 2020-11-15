<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet;

use SixtyEightPublishers\DoctrineQueryObjects\Exception\ResultSetLockException;

final class Lock
{
	/** @var bool  */
	private $locked = FALSE;

	/**
	 * @return void
	 */
	public function lock(): void
	{
		$this->locked = TRUE;
	}

	/**
	 * @return bool
	 */
	public function isLocked(): bool
	{
		return $this->locked;
	}

	/**
	 * @return void
	 * @throws \SixtyEightPublishers\DoctrineQueryObjects\Exception\ResultSetLockException;
	 */
	public function checkLock(): void
	{
		if ($this->isLocked()) {
			throw ResultSetLockException::default();
		}
	}
}
