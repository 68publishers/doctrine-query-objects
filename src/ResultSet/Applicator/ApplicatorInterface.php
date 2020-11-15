<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Applicator;

use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetInterface;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context\ResultSetContextInterface;

interface ApplicatorInterface
{
	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetInterface                $resultSet
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context\ResultSetContextInterface $context
	 *
	 * @return void
	 */
	public function __invoke(ResultSetInterface $resultSet, ResultSetContextInterface $context): void;
}
