<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\QueryFactory;

use Doctrine\ORM\Query;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;

final class EntityManagerQueryFactory implements QueryFactoryInterface
{
	/** @var \Doctrine\ORM\EntityManagerInterface  */
	private $em;

	/**
	 * @param \Doctrine\ORM\EntityManagerInterface $em
	 */
	public function __construct(EntityManagerInterface $em)
	{
		$this->em = $em;
	}

	/**
	 * {@inheritDoc}
	 */
	public function createQuery(string $dql = ''): Query
	{
		return $this->em->createQuery($dql);
	}

	/**
	 * {@inheritDoc}
	 */
	public function createNativeQuery(string $sql, ResultSetMapping $rsm): NativeQuery
	{
		return $this->em->createNativeQuery($sql, $rsm);
	}

	/**
	 * {@inheritDoc}
	 */
	public function createQueryBuilder(): QueryBuilder
	{
		return $this->em->createQueryBuilder();
	}
}
