# Changelog

All notable changes to `laravel-postcodeapi` will be documented in this file

## 2.0.0 - 2025-xx-xx

- Removed outdated Providers (Algolia, GeonamesDE, GeoPostcodeOrgUk, PostcodeData, PostcodeNL, PostcodesNL, Pstcd and UkPostcodes)
- Refactor'd Guzzle HttpClient to Laravel's native Http Client
- Adding support for Laravel 12 ([#52](https://github.com/nickurt/laravel-postcodeapi/issues/52))

## 1.21.0 - 2024-03-09

- Adding support for Laravel 11, dropping Laravel 9 and PHP8.1 ([#48](https://github.com/nickurt/laravel-postcodeapi/pull/48))

## 1.20.0 - 2024-01-24

- Fix/postco.de response keys longitude ([#47](https://github.com/nickurt/laravel-postcodeapi/issues/47))

## 1.19.0 - 2023-09-25

- wrong url for NationaalGeoRegister ([#46](https://github.com/nickurt/laravel-postcodeapi/issues/46))

## 1.18.0 - 2023-02-10

- Adding support for Laravel 10 ([#31](https://github.com/nickurt/laravel-postcodeapi/pull/31))

## 1.17.0 - 2022-02-10

- Adding support for Laravel 9 ([#30](https://github.com/nickurt/laravel-postcodeapi/pull/30))

## 1.16.1 - 2021-09-07

- Add url variable to MalformedURLException for debugging ([#29](https://github.com/nickurt/laravel-postcodeapi/pull/29))
- Allow null value for long/latitude ([#28](https://github.com/nickurt/laravel-postcodeapi/pull/28))
- Upgrade to GitHub-native Dependabot ([#27](https://github.com/nickurt/laravel-postcodeapi/pull/27))

## 1.16.0 - 2020-11-29

- Adding support for PHP 8.0, ditched PHP 7.2 and PHP 7.3

## 1.15.0 - 2020-09-09

- Adding support for Laravel 8 ([#26](https://github.com/nickurt/laravel-postcodeapi/pull/26))

## 1.14.0 - 2020-06-16

- Change visibility of find methods in Provider class ([#23](https://github.com/nickurt/laravel-postcodeapi/pull/23))

## 1.13.0 - 2020-05-08

- Support for PHP8.0 ([#21](https://github.com/nickurt/laravel-postcodeapi/pull/21))
- Fix authoritative autoloader issues ([#20](https://github.com/nickurt/laravel-postcodeapi/pull/20))

## 1.12.0 - 2020-04-25

- Support for 'Aliasing of providers' ([#17](https://github.com/nickurt/laravel-postcodeapi/issues/17), [#18](https://github.com/nickurt/laravel-postcodeapi/pull/18))

## 1.11.0 - 2020-02-24

- Adding support for Laravel 7
- Dropping support for Laravel 5.8

## 1.10.0 - 2019-12-02

- Added support for PHP 7.4

## 1.9.0 - 2019-09-04

- Added support for Laravel 6
