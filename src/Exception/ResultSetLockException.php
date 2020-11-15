<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Exception;

final class ResultSetLockException extends \RuntimeException implements ExceptionInterface
{
	/**
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\Exception\ResultSetLockException
	 */
	public static function default(): self
	{
		return new static('The ResultSet is locked because data was already fetched from a storage.');
	}
}
