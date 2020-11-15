<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet;

use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Applicator\ApplicatorInterface;

interface ResultSetInterface extends \IteratorAggregate, \Countable
{
	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Applicator\ApplicatorInterface $applicator
	 *
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetInterface
	 */
	public function apply(ApplicatorInterface $applicator): ResultSetInterface;

	/**
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface
	 */
	public function getOptions(): ResultSetOptionsInterface;

	/**
	 * @return array
	 */
	public function toArray(): array;

	/**
	 * @return bool
	 */
	public function isEmpty(): bool;

	/**
	 * @return int
	 */
	public function getTotalCount(): int;

	/**
	 * @return int
	 */
	public function count(): int;
}
