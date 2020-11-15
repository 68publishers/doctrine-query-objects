<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet;

use Iterator;
use ArrayIterator;
use Doctrine\ORM\Query;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\Tools\Pagination\Paginator;
use SixtyEightPublishers\DoctrineQueryObjects\ExecutableQueryObjectInterface;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context\ResultSetContext;
use SixtyEightPublishers\DoctrineQueryObjects\Exception\UnsupportedFeatureException;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Applicator\ApplicatorInterface;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context\ResultSetContextInterface;

class ResultSet implements ResultSetInterface
{
	/** @var \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context\ResultSetContextInterface */
	private $context;

	/** @var \SixtyEightPublishers\DoctrineQueryObjects\ExecutableQueryObjectInterface|NULL  */
	private $executableQueryObject;

	/** @var int|NULL */
	private $totalCount;

	/**
	 * @param \Doctrine\ORM\AbstractQuery                                                         $query
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ExecutableQueryObjectInterface|NULL      $executableQueryObject
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface|NULL $resultSetOptions
	 */
	public function __construct(AbstractQuery $query, ?ExecutableQueryObjectInterface $executableQueryObject = NULL, ?ResultSetOptionsInterface $resultSetOptions = NULL)
	{
		$resultSetOptions = $resultSetOptions ?? new ResultSetOptions();

		if ($query instanceof NativeQuery) {
			$resultSetOptions->setFetchJoinCollection(FALSE);
		}

		$resultSetOptions = new MonitoredResultSetOptions($resultSetOptions, function () {
			$this->context->getLock()->checkLock();
		});

		$this->context = $this->createContext($query, $resultSetOptions);
		$this->executableQueryObject = $executableQueryObject;
	}

	/**
	 * {@inheritDoc}
	 */
	public function apply(ApplicatorInterface $applicator): ResultSetInterface
	{
		$applicator($this, $this->context);

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getOptions(): ResultSetOptionsInterface
	{
		return $this->context->getOptions();
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \Exception
	 */
	public function toArray(): array
	{
		return iterator_to_array(clone $this->getIterator(), TRUE);
	}

	/**
	 * {@inheritDoc}
	 */
	public function isEmpty(): bool
	{
		$count = $this->getTotalCount();
		$query = $this->context->getQuery();
		$offset = $query instanceof Query ? $query->getFirstResult() : 0;

		return $count <= $offset;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \SixtyEightPublishers\DoctrineQueryObjects\Exception\UnsupportedFeatureException
	 */
	public function getTotalCount(): int
	{
		if (NULL !== $this->totalCount) {
			return $this->totalCount;
		}

		$query = $this->context->getQuery();

		if (!$query instanceof Query) {
			throw UnsupportedFeatureException::unsupportedQueryPaginator($query);
		}

		$paginator = $this->createPaginator($query);
		$totalCount = NULL !== $this->executableQueryObject ? $this->executableQueryObject->count($paginator) : $paginator->count();

		$this->context->getLock()->lock();

		return $this->totalCount = $totalCount;
	}

	/**
	 * {@inheritDoc}
	 *
	 * @throws \Exception
	 */
	public function count(): int
	{
		$iterator = clone $this->getIterator();

		return iterator_count($iterator);
	}

	/**
	 * {@inheritDoc}
	 */
	public function getIterator(): Iterator
	{
		if (NULL !== $this->context->getIterator()) {
			return $this->context->getIterator();
		}

		$query = $this->context->getQuery();
		$options = $this->getOptions();

		$query->setHydrationMode($options->getOption(ResultSetOptionsInterface::OPTION_HYDRATION_MODE, AbstractQuery::HYDRATE_OBJECT));

		if ($query instanceof Query && $options->getOption(ResultSetOptionsInterface::OPTION_FETCH_JOIN_COLLECTION) && (0 < $query->getMaxResults() || 0 < $query->getFirstResult())) {
			$iterator = $this->createPaginator($query)->getIterator();
		} else {
			$iterator = new ArrayIterator($query->getResult());
		}

		$this->context->getLock()->lock();
		$this->context->setIterator($iterator);

		return $iterator;
	}

	/**
	 * @param \Doctrine\ORM\AbstractQuery                                                    $query
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface $resultSetOptions
	 *
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Context\ResultSetContextInterface
	 */
	protected function createContext(AbstractQuery $query, ResultSetOptionsInterface $resultSetOptions): ResultSetContextInterface
	{
		return new ResultSetContext($query, new Lock(), $resultSetOptions);
	}

	/**
	 * @param \Doctrine\ORM\Query $query
	 *
	 * @return \Doctrine\ORM\Tools\Pagination\Paginator
	 */
	private function createPaginator(Query $query): Paginator
	{
		$options = $this->getOptions();
		$paginator = new Paginator($query, $options->getOption(ResultSetOptionsInterface::OPTION_FETCH_JOIN_COLLECTION));

		$paginator->setUseOutputWalkers($options->getOption(ResultSetOptionsInterface::OPTION_USE_OUTPUT_WALKERS));

		return $paginator;
	}
}
