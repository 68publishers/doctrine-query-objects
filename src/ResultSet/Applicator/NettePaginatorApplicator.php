<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Applicator;

use Nette\Utils\Paginator;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetInterface;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context\ResultSetContextInterface;

final class NettePaginatorApplicator implements ApplicatorInterface
{
	/** @var \Nette\Utils\Paginator  */
	private $paginator;

	/** @var int|NULL  */
	private $itemsPerPage;

	/**
	 * @param \Nette\Utils\Paginator $paginator
	 * @param int|NULL               $itemsPerPage
	 */
	public function __construct(Paginator $paginator, ?int $itemsPerPage = NULL)
	{
		$this->paginator = $paginator;
		$this->itemsPerPage = $itemsPerPage;
	}

	/**
	 * {@inheritDoc}
	 */
	public function __invoke(ResultSetInterface $resultSet, ResultSetContextInterface $context): void
	{
		if (NULL !== $this->itemsPerPage) {
			$this->paginator->setItemsPerPage($this->itemsPerPage);
		}

		$this->paginator->setItemCount($resultSet->getTotalCount());

		(new PagingApplicator($this->paginator->getOffset(), $this->paginator->getLength()))($resultSet, $context);
	}
}
