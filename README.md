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
$postCode18 = PostcodeApi::create('PostcodeApiNu2')->find('1118CP');
$postCode19 = PostcodeApi::create('PostcodeApiNu2')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode20 = PostcodeApi::create('PostcodeData')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode21 = PostcodeApi::create('PostcodeNL')->findByPostcodeAndHouseNumber('1118CP', '202');
$postCode22 = PostcodeApi::create('Pro6PP_NL')->find('1118CP');
$postCode23 = PostcodeApi::create('Pstcd')->find('1118CP');
$postCode24 = PostcodeApi::create('Pstcd')->findByPostcodeAndHouseNumber('1118CP', '202');
```
#### Route
```php
Route::get('/{postCode}', function($postCode) {
    $postCode25 = PostcodeApi::create('PostcodeApiNu2')->find($postCode);
    
    return Response::json($postCode1->toArray(), 200, [], JSON_PRETTY_PRINT);
});
```
#### Custom Configuration
```php
$postCode26 = PostcodeApi::create('PostcodeApiNu2');

var_dump($postCode26->getApiKey());
var_dump($postCode26->getRequestUrl());

$postCode26->setApiKey('MyApiKey');
$postCode26->setRequestUrl('https://api.postcodeapi.nu');

var_dump($postCode26);
```

### Providers
* [PostcodeNL](http://www.postcode.nl)
* [PostcodeApiNu2](http://www.postcodeapi.nu/) (v2/2016)
* [PostcodeData](http://www.postcodedata.nl/)
* [Pro6PP_NL](https://www.pro6pp.nl)
* [Pstcd](http://www.pstcd.nl/)
* [Pro6PP_BE](https://www.pro6pp.nl)
* [Geocodio](http://geocod.io/)
* [IdealPostcodes](https://ideal-postcodes.co.uk/)
* [GetAddresIO](https://getaddress.io/)
* [PostcodesIO](https://api.postcodes.io/)
* [UkPostcodes](http://uk-postcodes.com/postcode/)
* [GeoPostcodeOrgUk](http://www.geopostcode.org.uk/)
* [PostcodeApiComAu](http://postcodeapi.com.au/)

### Tests
```sh
bin/phpunit nickurt/laravel-postcodeapi/tests
```

- - - 