<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Bridge\Nette\DI;

use Nette\DI\CompilerExtension;

final class DoctrineQueryObjectsExtension extends CompilerExtension
{
	/**
	 * {@inheritDoc}
	 */
	public function loadConfiguration(): void
	{
		$this->loadDefinitionsFromConfig(
			$this->loadFromFile(__DIR__ . '/../config/services.neon')['services']
		);
	}
}
