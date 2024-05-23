# Change Log

All notable changes to this project will be documented in this file.

This projects adheres to [Semantic Versioning](http://semver.org/) and [Keep a CHANGELOG](http://keepachangelog.com/).

## [Unreleased][unreleased]
-

## [4.4.0] - 2024-05-23

### Added

- Set parameter `checkoutoption` to `combinedpage` for iDEAL 2.0. [#4](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/issues/4)

### Commits

- composer update ([4718c18](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/4718c18c57faecc60fca6bb609be70e4f74aabf9))

Full set of changes: [`4.3.5...4.4.0`][4.4.0]

[4.4.0]: https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/compare/v4.3.5...v4.4.0

## [4.3.5] - 2023-10-13

### Commits

- The `FILTER_UNSAFE_RAW` is not required, the default `sanitize_text_field` will work fine. ([b58b941](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/b58b941145bfc06156bac31917350ff1af6fce21))
- Removed old see ref. ([18de110](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/18de1100899fea9c474cf9fecd15384dfb669442))

Full set of changes: [`4.3.4...4.3.5`][4.3.5]

[4.3.5]: https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/compare/v4.3.4...v4.3.5

## [4.3.4] - 2023-07-12

### Commits

- Updated for removed payment ID fallback in formatted payment string (pronamic/wp-pronamic-pay-adyen#23). ([c88d738](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/c88d738b9f45afefa81385d15a8113330272ac4d))
- Set payment transaction ID on return. ([8947949](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/8947949d5eb0769e3e714b5de130e9680e87b85c))

Full set of changes: [`4.3.3...4.3.4`][4.3.4]

[4.3.4]: https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/compare/v4.3.3...v4.3.4

## [4.3.3] - 2023-06-01

### Commits

- Switch from `pronamic/wp-deployer` to `pronamic/pronamic-cli`. ([064f96e](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/064f96e345172b76a8c43616e002796f95007e2f))
- Updated .gitattributes ([aba1902](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/aba19026afd0f20c4ad6a5e90f8847d4b682cde0))

Full set of changes: [`4.3.2...4.3.3`][4.3.3]

[4.3.3]: https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/compare/v4.3.2...v4.3.3

## [4.3.2] - 2023-03-27

### Commits

- Set Composer type to `wordpress-plugin`. ([d1ea6c3](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/d1ea6c351e51adeb1ec3616bf331dad170e5a6d3))
- Updated .gitattributes ([ac81854](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/ac81854242dd2b3b0d7774b1c624a4b6330f58ef)) ([0e729e5](https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/commit/0e729e5ced27b8becb0fb82e18846224d8f9ff1e))

Full set of changes: [`4.3.1...4.3.2`][4.3.2]

[4.3.2]: https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/compare/v4.3.1...v4.3.2

## [4.3.1] - 2023-01-31
### Composer

- Changed `php` from `>=8.0` to `>=7.4`.
Full set of changes: [`4.3.0...4.3.1`][4.3.1]

[4.3.1]: https://github.com/pronamic/wp-pronamic-pay-ems-e-commerce/compare/v4.3.0...v4.3.1

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
