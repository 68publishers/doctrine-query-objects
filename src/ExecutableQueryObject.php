<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects;

use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\Tools\Pagination\Paginator;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSet;
use SixtyEightPublishers\DoctrineQueryObjects\Exception\UnexpectedValueException;
use SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface;
use SixtyEightPublishers\DoctrineQueryObjects\Exception\UnsupportedFeatureException;

final class ExecutableQueryObject implements ExecutableQueryObjectInterface
{
	/** @var \SixtyEightPublishers\DoctrineQueryObjects\QueryObjectInterface  */
	private $queryObject;

	/** @var \SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface  */
	private $queryFactory;

	/** @var \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface|NULL  */
	private $resultSetOptions;

	/** @var \Doctrine\ORM\AbstractQuery|NULL  */
	private $lastQuery;

	/** @var \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetInterface|NULL */
	private $lastResultSet;

	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\QueryObjectInterface                     $queryObject
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\QueryFactoryInterface       $queryFactory
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface|NULL $resultSetOptions
	 */
	public function __construct(QueryObjectInterface $queryObject, QueryFactoryInterface $queryFactory, ?ResultSetOptionsInterface $resultSetOptions = NULL)
	{
		$this->queryObject = $queryObject;
		$this->queryFactory = $queryFactory;
		$this->resultSetOptions = $resultSetOptions;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \Doctrine\ORM\NoResultException
	 * @throws \Doctrine\ORM\NonUniqueResultException
	 */
	public function count(?Paginator $paginator = NULL): int
	{
		$query = $this->queryObject->createCountQuery($this->queryFactory);

		if (NULL !== $query) {
			return $this->toQuery($query)->getSingleScalarResult();
		}

		if (NULL !== $paginator) {
			return $paginator->count();
		}

		$query = $this->getQuery();

		if (!$query instanceof Query) {
			throw UnsupportedFeatureException::unsupportedQueryPaginator($query);
		}

		$query->setFirstResult(NULL)
			->setMaxResults(NULL);

		$paginator = new Paginator($query, NULL !== $this->resultSetOptions ? $this->resultSetOptions->getOption(ResultSetOptionsInterface::OPTION_FETCH_JOIN_COLLECTION) : TRUE);
		$paginator->setUseOutputWalkers(NULL !== $this->resultSetOptions ? $this->resultSetOptions->getOption(ResultSetOptionsInterface::OPTION_USE_OUTPUT_WALKERS) : NULL);

		return $paginator->count();
	}

	/**
	 * {@inheritDoc}
	 */
	public function fetch()
	{
		$query = $this->getQuery();

		if ($query instanceof Query) {
			$query->setFirstResult(NULL)
				->setMaxResults(NULL);
		}

		if (NULL !== $this->resultSetOptions && AbstractQuery::HYDRATE_OBJECT !== $this->resultSetOptions->getOption(ResultSetOptionsInterface::OPTION_HYDRATION_MODE, AbstractQuery::HYDRATE_OBJECT)) {
			return $query->execute(NULL, $this->resultSetOptions->getOption(ResultSetOptionsInterface::OPTION_HYDRATION_MODE));
		}

		return $this->lastResultSet;
	}

	/**
	 * {@inheritDoc}
	 */
	public function fetchOne(): ?object
	{
		$query = $this->getQuery();

		if ($query instanceof Query) {
			$query->setFirstResult(NULL)
				->setMaxResults(1);
		}

		try {
			return $query->getSingleResult();
		} catch (NoResultException $e) {
			return NULL;
		}
	}

	/**
	 * @return \Doctrine\ORM\AbstractQuery
	 */
	protected function getQuery(): AbstractQuery
	{
		$query = $this->toQuery($this->queryObject->createQuery($this->queryFactory));

		if ($this->lastQuery instanceof Query && $query instanceof Query &&
			$this->lastQuery->getDQL() === $query->getDQL()) {
			$query = $this->lastQuery;
		}

		if ($this->lastQuery !== $query) {
			$this->lastResultSet = new ResultSet($query, $this, $this->resultSetOptions);
		}

		return $this->lastQuery = $query;
	}

	/**
	 * @param mixed $query
	 *
	 * @return \Doctrine\ORM\AbstractQuery
	 */
	private function toQuery($query): AbstractQuery
	{
		if ($query instanceof QueryBuilder) {
			$query = $query->getQuery();
		}

		if (!$query instanceof AbstractQuery) {
			throw new UnexpectedValueException(sprintf(
				'Query must be instance of %s or %s. %s given.',
				AbstractQuery::class,
				QueryBuilder::class,
				is_object($query) ? ('Instance of ' . get_class($query)) : gettype($query)
			));
		}

		return $query;
	}
}
