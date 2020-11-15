<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet;

use Doctrine\ORM\AbstractQuery;

interface ResultSetOptionsInterface
{
	public const OPTION_HYDRATION_MODE = 'hydration_mode';
	public const OPTION_FETCH_JOIN_COLLECTION = 'fetch_join_collection';
	public const OPTION_USE_OUTPUT_WALKERS = 'use_output_walkers';

	/**
	 * @param string $name
	 * @param mixed  $value
	 *
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface
	 */
	public function setOption(string $name, $value): ResultSetOptionsInterface;

	/**
	 * @param string     $name
	 * @param mixed|NULL $default
	 *
	 * @return mixed
	 */
	public function getOption(string $name, $default = NULL);

	/**
	 * @param int $hydrationMode
	 *
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface
	 */
	public function setHydrationMode(int $hydrationMode = AbstractQuery::HYDRATE_OBJECT): ResultSetOptionsInterface;

	/**
	 * @param bool $fetchJoinCollection
	 *
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface
	 */
	public function setFetchJoinCollection(bool $fetchJoinCollection): ResultSetOptionsInterface;

	/**
	 * @param bool|NULL $useOutputWalkers
	 *
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface
	 */
	public function setUseOutputWalkers(?bool $useOutputWalkers): ResultSetOptionsInterface;
}
