# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [0.3.0] - 2026-10-28

### Added

- Added Nette Tester tests (SQLite in memory) and GitHub Actions (coding style, tests on PHP 8.3, 8.4 and 8.5 with the lowest and highest dependencies).

### Changed

- Minimal PHP version is 8.3 (BC break).
- Added support for `doctrine/orm` 3 (and `doctrine/dbal` 4), the minimal `doctrine/orm` version is 2.10 (BC break).
- Added support for `nette/utils` 4, the `NettePaginatorApplicator` is tested with `nette/utils` 3.2+.
- `ResultSetOptions::create()` is a static method now (it could not be called statically before).
- Migrated PHP-CS-Fixer to v3 (`.php-cs-fixer.dist.php`).

### Removed

- Removed Travis CI and Scrutinizer configurations.

### Fixed

- Queries without an offset are reset with `Query::setFirstResult(0)` instead of `setFirstResult(NULL)`. It caused a `TypeError` in `ExecutableQueryObject::count()`, `fetch()`, `fetchOne()` and `PagingApplicator` with `doctrine/orm` 3 and a deprecation since `doctrine/orm` 2.18.
- `PagingApplicator` with a `NULL` offset works with `doctrine/orm` 3.
- `ExecutableQueryObject::count()` casts the result of a custom count query to `int`, drivers returning the count as a string caused a `TypeError`.

## [0.2.0] - 2023-01-03

### Changed

- Added PHP 8.1 into `composer.json`.
- Added support warning into the README.

## [0.1.1] - 2021-11-02

### Fixed

- Fixed working with hydration modes.

## [0.1] - 2020-11-30

### Added

- Initial release.

[Unreleased]: https://github.com/68publishers/doctrine-query-objects/compare/v0.3.0...HEAD
[0.3.0]: https://github.com/68publishers/doctrine-query-objects/compare/v0.2.0...v0.3.0
[0.2.0]: https://github.com/68publishers/doctrine-query-objects/compare/v0.1.1...v0.2.0
[0.1.1]: https://github.com/68publishers/doctrine-query-objects/compare/v0.1...v0.1.1
[0.1]: https://github.com/68publishers/doctrine-query-objects/releases/tag/v0.1
