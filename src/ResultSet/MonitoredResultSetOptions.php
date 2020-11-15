<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\ResultSet;

use Doctrine\ORM\AbstractQuery;

final class MonitoredResultSetOptions implements ResultSetOptionsInterface
{
	/** @var \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface  */
	private $options;

	/** @var callable  */
	private $monitoringCallback;

	/**
	 * @param \SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface $options
	 * @param callable                                                                       $monitoringCallback
	 */
	public function __construct(ResultSetOptionsInterface $options, callable $monitoringCallback)
	{
		$this->options = $options;
		$this->monitoringCallback = $monitoringCallback;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setOption(string $name, $value): ResultSetOptionsInterface
	{
		$this->callMonitoringCallback($name, $value);
		$this->options->setOption($name, $value);

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function getOption(string $name, $default = NULL)
	{
		return $this->options->getOption($name, $default);
	}

	/**
	 * {@inheritDoc}
	 */
	public function setHydrationMode(int $hydrationMode = AbstractQuery::HYDRATE_OBJECT): ResultSetOptionsInterface
	{
		$this->callMonitoringCallback(self::OPTION_HYDRATION_MODE, $hydrationMode);
		$this->options->setHydrationMode($hydrationMode);

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setFetchJoinCollection(bool $fetchJoinCollection): ResultSetOptionsInterface
	{
		$this->callMonitoringCallback(self::OPTION_FETCH_JOIN_COLLECTION, $fetchJoinCollection);
		$this->options->setFetchJoinCollection($fetchJoinCollection);

		return $this;
	}

	/**
	 * {@inheritDoc}
	 */
	public function setUseOutputWalkers(?bool $useOutputWalkers): ResultSetOptionsInterface
	{
		$this->callMonitoringCallback(self::OPTION_USE_OUTPUT_WALKERS, $useOutputWalkers);
		$this->options->setUseOutputWalkers($useOutputWalkers);

		return $this;
	}

	/**
	 * @param string $optionName
	 * @param mixed  $value
	 *
	 * @return void
	 */
	private function callMonitoringCallback(string $optionName, $value): void
	{
		$cb = $this->monitoringCallback;

		$cb($optionName, $value);
	}
}
