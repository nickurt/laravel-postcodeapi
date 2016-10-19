## Laravel PostcodeApi

### Installation
Install this package with composer:
```
php composer.phar require nickurt/laravel-postcodeapi:1.*
```

Add the provider to config/app.php file

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
```
#### Default - nl_BE
```php
$postCode17 = PostcodeApi::create('Pro6PP_BE')->find('1000');
```
#### Default - nl_NL
```php
$postCode18 = PostcodeApi::create('PostcodeApiNu')->find('1118CP');
$postCode19 = PostcodeApi::create('PostcodeApiNu')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode20 = PostcodeApi::create('PostcodeData')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode21 = PostcodeApi::create('PostcodeNL')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode22 = PostcodeApi::create('Pro6PP_NL')->find('1118CP');
$postCode23 = PostcodeApi::create('Pstcd')->find('1118CP');
$postCode24 = PostcodeApi::create('Pstcd')->findByPostcodeAndHouseNumber('1118CP', '202');
```
#### Route
```php
Route::get('/{postCode}', function($postCode) {
    $postCode25 = PostcodeApi::create('PostcodeApiNu')->find($postCode);
    
    return Response::json($postCode25->toArray(), 200, [], JSON_PRETTY_PRINT);
});
```
#### Custom Configuration
```php
$postCode26 = PostcodeApi::create('PostcodeApiNu');

var_dump($postCode26->getApiKey());
var_dump($postCode26->getRequestUrl());

$postCode26->setApiKey('MyApiKey');
$postCode26->setRequestUrl('https://api.postcodeapi.nu');

var_dump($postCode26);
```

### Providers
[Geocodio](http://geocod.io/), [GeoPostcodeOrgUk](http://www.geopostcode.org.uk/), [GetAddresIO](https://getaddress.io/), [IdealPostcodes](https://ideal-postcodes.co.uk/), [PostcodeApiComAu](http://postcodeapi.com.au/), [PostcodeApiNu](http://www.postcodeapi.nu/), [PostcodeData](http://www.postcodedata.nl/), [PostcodeNL](http://www.postcode.nl), [PostcodesIO](https://api.postcodes.io/), [Pro6PP_BE](https://www.pro6pp.nl), [Pro6PP_NL](https://www.pro6pp.nl), [Pstcd](http://www.pstcd.nl/), [UkPostcodes](http://uk-postcodes.com/postcode/)

### Tests
```sh
bin/phpunit nickurt/laravel-postcodeapi/tests
```

- - - 