<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

final class Article
{
	/** @var int */
	public $id;

	/** @var string */
	public $title;

	/** @var \Doctrine\Common\Collections\Collection<int, \SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures\Tag> */
	public $tags;

	public function __construct(int $id, string $title)
	{
		$this->id = $id;
		$this->title = $title;
		$this->tags = new ArrayCollection();
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
		$metadata->mapOneToMany(['fieldName' => 'tags', 'targetEntity' => Tag::class, 'mappedBy' => 'article']);
		$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
	}
}
