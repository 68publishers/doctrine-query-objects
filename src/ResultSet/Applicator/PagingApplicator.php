<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Applicator;

use Doctrine\ORM\Query;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetInterface;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context\ResultSetContextInterface;

final class PagingApplicator implements ApplicatorInterface
{
	/** @var int|NULL  */
	private $offset;

	/** @var int|NULL  */
	private $limit;

	/**
	 * @param int|NULL $offset
	 * @param int|NULL $limit
	 */
	public function __construct(?int $offset, ?int $limit)
	{
		$this->offset = $offset;
		$this->limit = $limit;
	}

	/**
	 * {@inheritDoc}
	 */
	public function __invoke(ResultSetInterface $resultSet, ResultSetContextInterface $context): void
	{
		$query = $context->getQuery();

		if ($query instanceof Query && ($query->getFirstResult() !== $this->offset || $query->getMaxResults() !== $this->limit)) {
			$query->setFirstResult($this->offset);
			$query->setMaxResults($this->limit);
			$context->setIterator(NULL);
		}
	}
}
