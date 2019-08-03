## Laravel PostcodeApi

[![Latest Stable Version](https://poser.pugx.org/nickurt/laravel-postcodeapi/v/stable?format=flat-square)](https://packagist.org/packages/nickurt/laravel-postcodeapi)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/nickurt/laravel-postcodeapi/master.svg?style=flat-square)](https://travis-ci.org/nickurt/laravel-postcodeapi)
[![Total Downloads](https://img.shields.io/packagist/dt/nickurt/laravel-postcodeapi.svg?style=flat-square)](https://packagist.org/packages/nickurt/laravel-postcodeapi)

### Installation
Install this package with composer:
```
composer require nickurt/laravel-postcodeapi
```

Add the provider to `config/app.php` file

```php
'nickurt\PostcodeApi\ServiceProvider',
```

and the facade in the file

```php
'PostcodeApi' => 'nickurt\PostcodeApi\Facade',
```

Copy the config files for the api

```
php artisan vendor:publish --provider="nickurt\PostcodeApi\ServiceProvider" --tag="config"
```

### Examples
#### Default - en_AU
```php
$postCode10 = PostcodeApi::create('PostcodeApiComAu')->find('3066');
```
#### Default - en_GB
```php
$postCode11 = PostcodeApi::create('GeoPostcodeOrgUk')->find('SW1A1AA');
$postCode12 = PostcodeApi::create('GetAddressIO')->find('SW1A1AA');
$postCode13 = PostcodeApi::create('IdealPostcodes')->find('SW1A1AA');
$postCode14 = PostcodeApi::create('PostcodesIO')->find('SW1A1AA');
$postCode15 = PostcodeApi::create('UkPostcodes')->find('SW1A1AA');
```
#### Default - en_US
```php
$postCode16 = PostcodeApi::create('Geocodio')->find('42370+Bob+Hope+Drive,+Rancho+Mirage+CA');
$postCode17 = PostcodeApi::create('Google')->find('42370');
```
#### Default - fr_FR
```php
$postCode18 = PostcodeApi::create('AdresseDataGouv')->find('75007');
$postCode19 = PostcodeApi::create('AdresseDataGouv')->findByPostcodeAndHouseNumber('75007', '5 Avenue Anatole France');
```
#### Default - nl_BE
```php
$postCode20 = PostcodeApi::create('Pro6PP_BE')->find('1000');
```
#### Default - nl_NL
```php
$postCode21 = PostcodeApi::create('ApiPostcode')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode22 = PostcodeApi::create('NationaalGeoRegister')->find('1118CP');
$postCode23 = PostcodeApi::create('NationaalGeoRegister')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode24 = PostcodeApi::create('PostcoDe')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode25 = PostcodeApi::create('PostcodeApiNu')->find('1118CP');
$postCode26 = PostcodeApi::create('PostcodeApiNu')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode27 = PostcodeApi::create('PostcodeData')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode28 = PostcodeApi::create('PostcodeNL')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode29 = PostcodeApi::create('PostcodesNL')->find('1118CP');
$postCode30 = PostcodeApi::create('PostcodesNL')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode31 = PostcodeApi::create('Pro6PP_NL')->find('1118CP');
$postCode32 = PostcodeApi::create('Pstcd')->find('1118CP');
$postCode33 = PostcodeApi::create('Pstcd')->findByPostcodeAndHouseNumber('1118CP', '202');
```
#### Route
```php
Route::get('/{postCode}', function($postCode) {
    $postCode34 = PostcodeApi::create('PostcodeApiNu')->find($postCode);
    
    return Response::json($postCode25->toArray(), 200, [], JSON_PRETTY_PRINT);
});
```

### Providers
[AdresseDataGouv](https://adresse.data.gouv.fr), [ApiPostcode](https://api-postcode.nl), [Geocodio](https://www.geocod.io), [GeoPostcodeOrgUk](http://www.geopostcode.org.uk), [GetAddresIO](https://getaddress.io), [Google](https://developers.google.com/maps/documentation/geocoding/intro), [IdealPostcodes](https://ideal-postcodes.co.uk), [NationaalGeoRegister](https://nationaalgeoregister.nl/geonetwork/srv/dut/catalog.search#/home), [postco.de](https://postco.de), [PostcodeApiComAu](https://postcodeapi.com.au), [PostcodeApiNu](https://www.postcodeapi.nu), [PostcodeData](http://www.postcodedata.nl), [PostcodeNL](https://www.postcode.nl), [PostcodesIO](https://api.postcodes.io), [PostcodesNL](https://www.postcodes.nl), [Pro6PP_BE](https://www.pro6pp.nl), [Pro6PP_NL](https://www.pro6pp.nl), [Pstcd](http://www.pstcd.nl/), [UkPostcodes](http://uk-postcodes.com/postcode)

### Tests
```sh
composer test
```

- - - 
