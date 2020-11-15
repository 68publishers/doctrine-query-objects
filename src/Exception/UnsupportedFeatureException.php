<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Exception;

use Doctrine\ORM\AbstractQuery;

final class UnsupportedFeatureException extends \LogicException implements ExceptionInterface
{
	public static function unsupportedQueryPaginator(AbstractQuery $query): self
	{
		return new static(sprintf(
			'Paginator feature is not supported for query of type %s',
			get_class($query)
		));
	}
}
