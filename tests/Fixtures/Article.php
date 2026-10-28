<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures;

use Doctrine\ORM\Mapping\ClassMetadata;

final class Article
{
	/** @var int */
	public $id;

	/** @var string */
	public $title;

	public function __construct(int $id, string $title)
	{
		$this->id = $id;
		$this->title = $title;
	}

	/**
	 * Mapping for the StaticPHPDriver (works with all supported ORM versions)
	 *
	 * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata
	 */
	public static function loadMetadata($metadata): void
	{
		$metadata->setPrimaryTable(['name' => 'article']);
		$metadata->mapField(['fieldName' => 'id', 'type' => 'integer', 'id' => TRUE]);
		$metadata->mapField(['fieldName' => 'title', 'type' => 'string', 'length' => 255]);
		$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
	}
}
