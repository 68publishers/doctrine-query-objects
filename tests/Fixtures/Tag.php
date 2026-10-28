<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures;

use Doctrine\ORM\Mapping\ClassMetadata;

final class Tag
{
	/** @var int */
	public $id;

	/** @var \SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures\Article */
	public $article;

	public function __construct(int $id, Article $article)
	{
		$this->id = $id;
		$this->article = $article;
		$article->tags->add($this);
	}

	/**
	 * Mapping for the StaticPHPDriver (works with all supported ORM versions)
	 *
	 * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata
	 */
	public static function loadMetadata($metadata): void
	{
		$metadata->setPrimaryTable(['name' => 'tag']);
		$metadata->mapField(['fieldName' => 'id', 'type' => 'integer', 'id' => TRUE]);
		$metadata->mapManyToOne(['fieldName' => 'article', 'targetEntity' => Article::class, 'inversedBy' => 'tags']);
		$metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
	}
}
