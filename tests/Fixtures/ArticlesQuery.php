<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures;

use Doctrine\ORM\Query\ResultSetMapping;
use SixtyEightPublishers\DoctrineQueryObjects\AbstractQueryObject;
use SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface;

final class ArticlesQuery extends AbstractQueryObject
{
	/** @var int|NULL */
	private $minId;

	/** @var bool */
	private $stringCountQuery;

	/** @var bool */
	private $joinTags;

	public function __construct(?int $minId = NULL, bool $stringCountQuery = FALSE, bool $joinTags = FALSE)
	{
		$this->minId = $minId;
		$this->stringCountQuery = $stringCountQuery;
		$this->joinTags = $joinTags;
	}

	/**
	 * {@inheritDoc}
	 */
	public function createQuery(QueryFactoryInterface $queryFactory)
	{
		$qb = $queryFactory->createQueryBuilder()
			->select('a')
			->from(Article::class, 'a')
			->orderBy('a.id');

		if ($this->joinTags) {
			$qb->leftJoin('a.tags', 't')->addSelect('t')->addOrderBy('t.id');
		}

		if (NULL !== $this->minId) {
			$qb->andWhere('a.id >= :minId')->setParameter('minId', $this->minId);
		}

		return $qb;
	}

	/**
	 * {@inheritDoc}
	 */
	public function createCountQuery(QueryFactoryInterface $queryFactory)
	{
		if (!$this->stringCountQuery) {
			return NULL;
		}

		# some drivers (e.g. mysqli, oci8) return the count as a string
		$rsm = new ResultSetMapping();
		$rsm->addScalarResult('cnt', 'cnt');

		return $queryFactory->createNativeQuery('SELECT CAST(COUNT(*) AS TEXT) AS cnt FROM article', $rsm);
	}
}
