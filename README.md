> :warning: Warning! This package does not have active support, it exists only for the historical needs of the author.

# Doctrine Query Objects

Query Objects for Doctrine ORM inspired by implementation in [kdyby/doctrine](https://github.com/Kdyby/Doctrine).

## Installation

The best way to install 68publishers/doctrine-query-objects is using Composer:

```bash
$ composer require 68publishers/doctrine-query-objects
```

Requirements: PHP `^8.3` and `doctrine/orm` `^2.10 || ^3.0`. The Nette integration requires `nette/di` `^3.0.3`, the `NettePaginatorApplicator` requires `nette/utils` `^3.2 || ^4.0`.

## Upgrade

### From 0.2 to 0.3

- The minimal PHP version is 8.3 and the minimal `doctrine/orm` version is 2.10.
- `ResultSetOptions::create()` is a static method now.
- Queries with no offset use `setFirstResult(0)` instead of `setFirstResult(NULL)` (required by ORM 3).

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
$ vendor/bin/php-cs-fixer fix -v --dry-run
```

and

```bash
$ composer run tests
```
