<?php

declare(strict_types=1);

namespace SixtyEightPublishers\DoctrineQueryObjects\Tests;

use Tester\Assert;
use Tester\TestCase;
use Nette\Utils\Paginator;
use Doctrine\ORM\AbstractQuery;
use Doctrine\Deprecations\Deprecation;
use SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures\Article;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptions;
use SixtyEightPublishers\DoctrineQueryObjects\ExecutableQueryObjectFactory;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetInterface;
use SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures\ArticlesQuery;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\ResultSetOptionsInterface;
use SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures\EntityManagerFactory;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Applicator\PagingApplicator;
use SixtyEightPublishers\DoctrineQueryObjects\QueryFactory\EntityManagerQueryFactory;
use SixtyEightPublishers\DoctrineQueryObjects\ResultSet\Applicator\NettePaginatorApplicator;

require __DIR__ . '/bootstrap.php';

final class ExecutableQueryObjectTest extends TestCase
{
	/** @var \Doctrine\ORM\EntityManagerInterface */
	private $em;

	/** @var \SixtyEightPublishers\DoctrineQueryObjects\ExecutableQueryObjectFactoryInterface */
	private $factory;

	public function testFetchWithObjectHydration(): void
	{
		$resultSet = $this->factory->create(new ArticlesQuery())->fetch();

		Assert::type(ResultSetInterface::class, $resultSet);
		Assert::same([1, 2, 3, 4, 5], $this->ids($resultSet->toArray()));
		Assert::same(5, $resultSet->getTotalCount());
		Assert::same(5, $resultSet->count());
		Assert::false($resultSet->isEmpty());
	}

	public function testFetchWithArrayHydration(): void
	{
		$options = ResultSetOptions::create()->setHydrationMode(AbstractQuery::HYDRATE_ARRAY);
		$result = $this->factory->create(new ArticlesQuery(4), $options)->fetch();

		Assert::same([['id' => 4, 'title' => 'Article 4'], ['id' => 5, 'title' => 'Article 5']], $result);
	}

	public function testPagingApplicator(): void
	{
		$resultSet = $this->factory->create(new ArticlesQuery())->fetch();
		$resultSet->apply(new PagingApplicator(2, 2));

		Assert::same([3, 4], $this->ids($resultSet->toArray()));
		Assert::same(5, $resultSet->getTotalCount());
	}

	public function testPagingApplicatorWithoutOffset(): void
	{
		$resultSet = $this->factory->create(new ArticlesQuery())->fetch();
		$resultSet->apply(new PagingApplicator(NULL, 3));

		Assert::same([1, 2, 3], $this->ids($resultSet->toArray()));

		$resultSet = $this->factory->create(new ArticlesQuery())->fetch();
		$resultSet->apply(new PagingApplicator(NULL, NULL));

		Assert::same([1, 2, 3, 4, 5], $this->ids($resultSet->toArray()));
	}

	public function testPagingWithFetchJoinCollection(): void
	{
		$options = ResultSetOptions::create()->setFetchJoinCollection(TRUE);
		$resultSet = $this->factory->create(new ArticlesQuery(), $options)->fetch();
		$resultSet->apply(new PagingApplicator(1, 2));

		Assert::same([2, 3], $this->ids($resultSet->toArray()));
		Assert::same(5, $resultSet->getTotalCount());
	}

	public function testNettePaginatorApplicator(): void
	{
		$paginator = new Paginator();
		$paginator->setPage(3);

		$resultSet = $this->factory->create(new ArticlesQuery())->fetch();
		$resultSet->apply(new NettePaginatorApplicator($paginator, 2));

		Assert::same([5], $this->ids($resultSet->toArray()));
		Assert::same(3, $paginator->getPageCount());
	}

	public function testFetchOne(): void
	{
		$article = $this->factory->create(new ArticlesQuery(3))->fetchOne();

		Assert::type(Article::class, $article);
		Assert::same(3, $article->id);
		Assert::null($this->factory->create(new ArticlesQuery(10))->fetchOne());
	}

	public function testCount(): void
	{
		Assert::same(3, $this->factory->create(new ArticlesQuery(3))->count());
		Assert::same(5, $this->factory->create(new ArticlesQuery(NULL, TRUE))->count());
	}

	public function testResultSetOptionsCanBeCreatedStatically(): void
	{
		Assert::type(ResultSetOptionsInterface::class, ResultSetOptions::create());
	}

	protected function setUp(): void
	{
		$this->em = EntityManagerFactory::create();
		$this->factory = new ExecutableQueryObjectFactory(new EntityManagerQueryFactory($this->em));

		# the lowest versions of DBAL trigger their own deprecations
		if (class_exists(Deprecation::class) && !getenv('TESTS_IGNORE_DEPRECATIONS')) {
			Deprecation::enableTrackingDeprecations();
		}
	}

	protected function tearDown(): void
	{
		if (class_exists(Deprecation::class) && !getenv('TESTS_IGNORE_DEPRECATIONS')) {
			# e.g. passing NULL to Query::setFirstResult() is deprecated since ORM 2.18
			Assert::same([], array_filter(Deprecation::getTriggeredDeprecations()), 'Doctrine deprecations');
			Deprecation::disable();
		}
	}

	/**
	 * @param array<\SixtyEightPublishers\DoctrineQueryObjects\Tests\Fixtures\Article> $articles
	 *
	 * @return array<int>
	 */
	private function ids(array $articles): array
	{
		return array_values(array_map(static function (Article $article): int {
			return $article->id;
		}, $articles));
	}
}

(new ExecutableQueryObjectTest())->run();
