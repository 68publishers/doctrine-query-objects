> :warning: Warning! This package does not have active support, it exists only for the historical needs of the author.

# Doctrine Query Objects

Query Objects for Doctrine ORM inspired by implementation in [kdyby/doctrine](https://github.com/Kdyby/Doctrine).

## Installation

The best way to install 68publishers/doctrine-query-objects is using Composer:

```bash
$ composer require 68publishers/doctrine-query-objects
```

## Configuration

```neon
extensions:
    doctrine_query_objects: SixtyEightPublishers\DoctrineQueryObjects\Bridge\Nette\DI\DoctrineQueryObjectsExtension
```

## Usage

@todo

## Contributing

Before committing any changes, don't forget to run

```bash
$ vendor/bin/php-cs-fixer fix --config=.php_cs.dist -v --dry-run
```

and

```bash
$ composer run tests
```
