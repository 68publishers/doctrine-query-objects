<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet;

use Doctrine\ORM\AbstractQuery;

class ResultSetOptions implements ResultSetOptionsInterface
{
	/** @var array  */
	protected $options = [
		self::OPTION_HYDRATION_MODE => NULL,
		self::OPTION_FETCH_JOIN_COLLECTION => FALSE,
		self::OPTION_USE_OUTPUT_WALKERS => NULL,
	];

	/**
	 * @return \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptions
	 */
	public function create(): self
	{
		return new static();
	}

	/**
	 * {@inheritDoc}
	 */
	public function setOption(string $name, $value): ResultSetOptionsInterface
	{
		$this->options[$name] = $value;

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getOption(string $name, $default = NULL)
	{
		return $this->options[$name] ?? $default;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setHydrationMode(int $hydrationMode = AbstractQuery::HYDRATE_OBJECT): ResultSetOptionsInterface
	{
		return $this->setOption(self::OPTION_HYDRATION_MODE, $hydrationMode);
	}

	/**
	 * {@inheritDoc}
	 */
	public function setFetchJoinCollection(bool $fetchJoinCollection): ResultSetOptionsInterface
	{
		return $this->setOption(self::OPTION_FETCH_JOIN_COLLECTION, $fetchJoinCollection);
	}

	/**
	 * {@inheritDoc}
	 */
	public function setUseOutputWalkers(?bool $useOutputWalkers): ResultSetOptionsInterface
	{
		return $this->setOption(self::OPTION_USE_OUTPUT_WALKERS, $useOutputWalkers);
	}
}
