# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

## [1.2.3] - 2024-05-15

### Commits

- Fixed "It is recommended not to use reserved keyword "array" as". ([a71a7e4](https://github.com/pronamic/wp-http/commit/a71a7e4301c924712714690553c1e5360d9909e9))
- Fixed "All output should be run through an escaping function" warnings. ([d8651c6](https://github.com/pronamic/wp-http/commit/d8651c650403550d575f85eec74948457535b241))

Full set of changes: [`1.2.2...1.2.3`][1.2.3]

[1.2.3]: https://github.com/pronamic/wp-http/compare/v1.2.2...v1.2.3

## [1.2.2] - 2023-03-27

### Commits

- Set Composer type to WordPress plugin. ([f35dfc2](https://github.com/pronamic/wp-http/commit/f35dfc22fb486bf3ec785698221f9d07766f985d))
- Updated .gitattributes ([c557adf](https://github.com/pronamic/wp-http/commit/c557adf7fdb2040885003fb6713742d5693c55a8))

Full set of changes: [`1.2.1...1.2.2`][1.2.2]

[1.2.2]: https://github.com/pronamic/wp-http/compare/v1.2.1...v1.2.2

## [1.2.1] - 2023-01-31
### Composer

- Changed `php` from `>=8.0` to `>=7.4`.
Full set of changes: [`1.2.0...1.2.1`][1.2.1]

[1.2.1]: https://github.com/pronamic/wp-http/compare/v1.2.0...v1.2.1

## [1.2.0] - 2022-12-20
- Increased minimum PHP version to version `8` or higher.
- Improved support for PHP `8.1` and `8.2`.
- Removed usage of deprecated constant `FILTER_SANITIZE_STRING`.

Full set of changes: [`1.1.3...1.2.0`][1.2.0]

[1.2.0]: https://github.com/pronamic/wp-http/compare/v1.1.3...v1.2.0

## [1.1.3] - 2022-09-23
- Coding standards.

[1.1.3]: https://github.com/pronamic/wp-http/compare/1.1.2...1.1.3

## [1.1.2] - 2022-04-11
- Updated libraries.
- Happy 2022.
- Coding standards.

## [1.1.1] - 2021-06-18
- Added body content to cURL and HTTPie formatters.

## [1.1.0] - 2021-05-20
### Added
- Introduced a `$response->simplexml()` function similar to the `$response->json()` function.

## [1.0.1] - 2021-05-11
### Fixed
- Improved 'http_request_args' filter removal related to Query Monitor conflict.

## [1.0.0] - 2021-04-26
- First release.

[Unreleased]: https://github.com/pronamic/wp-http/compare/1.1.1...HEAD
[1.1.2]: https://github.com/pronamic/wp-http/compare/1.1.1...1.1.2
[1.1.1]: https://github.com/pronamic/wp-http/compare/1.1.0...1.1.1
[1.1.0]: https://github.com/pronamic/wp-http/compare/1.0.1...1.1.0
[1.0.1]: https://github.com/pronamic/wp-http/compare/1.0.0...1.0.1
[1.0.0]: https://github.com/pronamic/wp-http/releases/tag/1.0.0
