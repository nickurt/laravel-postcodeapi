## Laravel PostcodeApi
[![Build Status](https://github.com/nickurt/laravel-postcodeapi/workflows/tests/badge.svg)](https://github.com/nickurt/laravel-postcodeapi/actions)
[![Total Downloads](https://poser.pugx.org/nickurt/laravel-postcodeapi/d/total.svg)](https://packagist.org/packages/nickurt/laravel-postcodeapi)
[![Latest Stable Version](https://poser.pugx.org/nickurt/laravel-postcodeapi/v/stable.svg)](https://packagist.org/packages/nickurt/laravel-postcodeapi)
[![MIT Licensed](https://poser.pugx.org/nickurt/laravel-postcodeapi/license.svg)](LICENSE.md)

### Installation
Install this package with composer:
```
composer require nickurt/laravel-postcodeapi
```

Copy the config files for the api
```
php artisan vendor:publish --provider="nickurt\PostcodeApi\ServiceProvider" --tag="config"
```

### Examples
#### Default - de_DE
```php
$postCode10 = PostcodeApi::create('ZippopotamusDE')->find('07751');
```
#### Default - en_AU
```php
$postCode11 = PostcodeApi::create('PostcodeApiComAu')->find('3066');
```
#### Default - en_GB
```php
$postCode12 = PostcodeApi::create('GetAddressIO')->find('SW1A1AA');
$postCode13 = PostcodeApi::create('IdealPostcodes')->find('SW1A1AA');
$postCode14 = PostcodeApi::create('PostcodesIO')->find('SW1A1AA');
```
#### Default - en_US
```php
$postCode15 = PostcodeApi::create('Bing')->find('92270');
$postCode16 = PostcodeApi::create('Geocodio')->find('92270');
$postCode17 = PostcodeApi::create('Google')->find('92270');
$postCode18 = PostcodeApi::create('Here')->find('92270');
$postCode19 = PostcodeApi::create('LocationIQ')->find('92270');
$postCode20 = PostcodeApi::create('Mapbox')->find('92270');
$postCode21 = PostcodeApi::create('OpenCage')->find('92270');
$postCode22 = PostcodeApi::create('TomTom')->find('92270');
```
#### Default - fr_FR
```php
$postCode23 = PostcodeApi::create('AdresseDataGouv')->find('75007');
$postCode24 = PostcodeApi::create('AdresseDataGouv')->findByPostcodeAndHouseNumber('75007', '5 Avenue Anatole France');
```
#### Default - nl_BE
```php
$postCode25 = PostcodeApi::create('Pro6PP_BE')->find('1000');
```
#### Default - nl_NL
```php
$postCode26 = PostcodeApi::create('ApiPostcode')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode27 = PostcodeApi::create('NationaalGeoRegister')->find('1118CP');
$postCode28 = PostcodeApi::create('NationaalGeoRegister')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode29 = PostcodeApi::create('PostcoDe')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode30 = PostcodeApi::create('PostcodeApiNu')->find('1118CP');
$postCode31 = PostcodeApi::create('PostcodeApiNu')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode32 = PostcodeApi::create('PostcodeApiNuV3')->find('1118CP');
$postCode33 = PostcodeApi::create('PostcodeApiNuV3')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode34 = PostcodeApi::create('PostcodeNL')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode35 = PostcodeApi::create('Pro6PP_NL')->find('1118CP');
```
#### Route
```php
Route::get('/{postCode}', function($postCode) {
    $postCode36 = PostcodeApi::create('PostcodeApiNu')->find($postCode);
    
    return Response::json($postCode35->toArray(), 200, [], JSON_PRETTY_PRINT);
});
```

### Providers
[AdresseDataGouv](https://adresse.data.gouv.fr), [ApiPostcode](https://api-postcode.nl), [Bing](https://www.bingmapsportal.com), [Geocodio](https://www.geocod.io), [GetAddresIO](https://getaddress.io), [Google](https://developers.google.com/maps/documentation/geocoding/intro), [Here](https://www.here.com), [IdealPostcodes](https://ideal-postcodes.co.uk), [LocationIQ](https://locationiq.com), [Mapbox](https://www.mapbox.com/), [NationaalGeoRegister](https://nationaalgeoregister.nl/geonetwork/srv/dut/catalog.search#/home), [OpenCage](https://opencagedata.com/), [postco.de](https://postco.de), [PostcodeApiComAu](https://postcodeapi.com.au), [PostcodeApiNu](https://www.postcodeapi.nu), [PostcodeNL](https://www.postcode.nl), [PostcodesIO](https://api.postcodes.io), [Pro6PP_BE](https://www.pro6pp.nl), [Pro6PP_NL](https://www.pro6pp.nl), [TomTom](https://developer.tomtom.com/content/search-api-explorer)
### Tests
```sh
composer test
```

- - - 
