<?php

return [
    'ApiPostcode' => [
        'url' => 'https://json.api-postcode.nl/',
        'key' => '',
        'code' => 'nl_NL'
    ],
    'NationaalGeoRegister' => [
        'url' => 'https://api.pdok.nl/bzk/locatieserver/search/v3_1/free',
        'key' => '',
        'code' => 'nl_NL'
    ],
    'PostcoDe' => [
        'url' => 'https://api.postco.de/v1/postcode/%s/%s',
        'key' => '',
        'code' => 'nl_NL'
    ],
    'PostcodeNL' => [
        'url' => 'https://api.postcode.nl/rest/addresses/%s/%s',
        'key' => '',
        'secret' => '',
        'code' => 'nl_NL'
    ],
    'PostcodeApiNu' => [
        'url' => 'https://postcode-api.apiwise.nl/v2/addresses/?postcode=%s&number=%s',
        'key' => '',
        'code' => 'nl_NL',
    ],
    'PostcodeApiNuV3' => [
        'url' => 'https://api.postcodeapi.nu/v3/lookup/%s/%s',
        'key' => '',
        'code' => 'nl_NL'
    ],
    'PostcodeApiNuV3Sandbox' => [
        'alias' => \nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNuV3::class,
        'url' => 'https://sandbox.postcodeapi.nu/v3/lookup/%s/%s',
        'key' => '',
        'code' => 'nl_NL'
    ],
    'Pro6PP_NL' => [
        'url' => 'https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&nl_sixpp=%s',
        'key' => '',
        'code' => 'nl_NL',
    ],

    'Pro6PP_BE' => [
        'url' => 'https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&be_fourpp=%s',
        'key' => '',
        'code' => 'nl_BE',
    ],

    'Bing' => [
        'url' => 'https://dev.virtualearth.net/REST/v1/Locations',
        'key' => '',
        'code' => 'en_US'
    ],
    'Geocodio' => [
        'url' => 'https://api.geocod.io/v1.3/geocode/?q=%s&api_key=%s',
        'key' => '',
        'code' => 'en_US',
    ],
    'Google' => [
        'url' => 'https://maps.googleapis.com/maps/api/geocode/json',
        'key' => '',
        'code' => 'en_US',
    ],
    'Here' => [
        'url' => 'https://geocoder.api.here.com/6.2/geocode.json',
        'key' => '',
        'secret' => '',
        'code' => 'en_US',
    ],
    'LocationIQ' => [
        'url' => 'https://us1.locationiq.com/v1/search.php',
        'key' => '',
        'code' => 'en_US',
    ],
    'Mapbox' => [
        'url' => 'https://api.mapbox.com/geocoding/v5/mapbox.places/%s.json',
        'key' => '',
        'code' => 'en_US',
    ],
    'OpenCage' => [
        'url' => 'https://api.opencagedata.com/geocode/v1/json',
        'key' => '',
        'code' => 'en_US',
    ],
    'TomTom' => [
        'url' => 'https://api.tomtom.com/search/2/geocode/%s.json',
        'key' => '',
        'code' => 'en_US',
    ],

    'IdealPostcodes' => [
        'url' => 'https://api.ideal-postcodes.co.uk/v1/postcodes/%s?api_key=%s',
        'key' => '',
        'code' => 'en_GB'
    ],
    'GetAddressIO' => [
        'url' => 'https://api.getaddress.io/find',
        'key' => '',
        'code' => 'en_GB'
    ],
    'PostcodesIO' => [
        'url' => 'https://api.postcodes.io/postcodes?q=%s',
        'key' => '',
        'code' => 'en_GB',
    ],

    'PostcodeApiComAu' => [
        'url' => 'https://v0.postcodeapi.com.au/suburbs/%s.json',
        'key' => '',
        'code' => 'en_AU'
    ],

    'AddresseDataGouv' => [
        'url' => 'https://api-adresse.data.gouv.fr/search/?q=%s&postcode=%s&limit=1',
        'key' => '',
        'code' => 'fr_FR'
    ],
   'ZippopotamusDE' => [
        'url' => 'https://api.zippopotam.us/DE/%s',
        'key' => '',
        'code' => 'de_DE'
    ]
];
