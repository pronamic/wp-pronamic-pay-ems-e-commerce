# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [4.3.0] - 2022-12-29

### Commits

- No longer use `filter_` functions and deprecated `FILTER_SANITIZE_STRING`. ([c91dc03](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/c91dc03d507748761d25afe34ff344da94162d7b))

### Composer

- Changed `php` from `>=5.6.20` to `>=8.0`.
- Changed `wp-pay/core` from `^4.0` to `v4.6.0`.
	Release notes: https://github.com/pronamic/wp-pay-core/releases/tag/v4.6.0
Full set of changes: [`4.2.0...4.3.0`][4.3.0]

[4.3.0]: https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/compare/v4.2.0...v4.3.0

## [4.2.0] - 2022-09-26
- Updated payment methods registration.

## [4.1.0] - 2022-04-11
- No longer use core gateweay mode.

## [4.0.0] - 2022-01-11
### Changed
- Updated to https://github.com/pronamic/wp-pay-core/releases/tag/4.0.0.

## [3.0.1] - 2021-08-18
- Fixed `chargetotal` number format.

## [3.0.0] - 2021-08-05
- Updated to `pronamic/wp-pay-core`  version `3.0.0`.
- Updated to `pronamic/wp-money`  version `2.0.0`.
- Switched to `pronamic/wp-coding-standards`.

## [2.1.2] - 2021-04-26
- Happy 2021.

## [2.1.1] - 2020-04-20
- Fixed incorrect default tag in description of Order ID settings field.

## [2.1.0] - 2020-03-19
- Extend from AbstractGatewayIntegration class.

## [2.0.4] - 2019-12-22
- Added URL to manual in gateway settings.
- Updated output fields to use payment.
- Updated payment status class name.

## [2.0.3] - 2019-09-10
- Added context to the 'notification' translatable strings.

## [2.0.2] - 2019-08-27
- Updated packages.

## [2.0.1] - 2018-12-12
- Fix using advanced order ID setting.

## [2.0.0] - 2018-05-09
- Switched to PHP namespaces.

## [1.0.4] - 2017-05-01
- Added missing Bancontact payment method transformation.
- Added leap of faith payment method support.

## [1.0.3] - 2017-03-15
- Set decimal and group separators for `chargetotal` parameter according to specs.
- Added support for Bancontact payment method.
- No longer filter storename and shared secret setting fields.

## [1.0.2] - 2017-01-25
- Make sure always the same transaction date time is used.
- Make sure to not encode quotes.

## [1.0.1] - 2016-10-20
- Added transaction feedback status setting.
- Fixed - Too many arguments for function `__`.

## 1.0.0 - 2016-07-06
- First release.

[unreleased]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/4.2.0...HEAD
[4.2.0]: https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/compare/4.1.0...4.2.0
[4.1.0]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/4.0.0...4.1.0
[4.0.0]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/3.0.1...4.0.0
[3.0.1]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/3.0.0...3.0.1
[3.0.0]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/2.1.2...3.0.0
[2.1.2]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/2.1.1...2.1.2
[2.1.1]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/2.1.0...2.1.1
[2.1.0]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/2.0.4...2.1.0
[2.0.4]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/2.0.3...2.0.4
[2.0.3]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/2.0.2...2.0.3
[2.0.2]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/2.0.1...2.0.2
[2.0.1]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/2.0.0...2.0.1
[2.0.0]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/1.0.4...2.0.0
[1.0.4]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/1.0.3...1.0.4
[1.0.3]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/1.0.2...1.0.3
[1.0.2]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/1.0.1...1.0.2
[1.0.1]: https://github.com/wp-pay-gateways/ems-e-commerce/compare/1.0.0...1.0.1
