<?php

return [
    'PostcodeNL'    => [
        'url'       =>  'https://api.postcode.nl/rest/addresses/%s/%s',
        'key'       =>  '',
        'secret'    =>  '',
        'code'      =>  'nl_NL'
    ],
    'PostcodeApiNu2'=> [
        'url'       =>  'https://postcode-api.apiwise.nl/v2/addresses/?postcode=%s&number=%s',
        'key'       =>  '',
        'code'      =>  'nl_NL',
    ],
    'PostcodeData'  => [
        'url'       =>  'http://api.postcodedata.nl/v1/postcode/?postcode=%s&streetnumber=%s&ref=%s',
        'key'       =>  '',
        'code'      =>  'nl_NL',
    ], 
    'Pro6PP_NL'     =>  [
        'url'       =>  'https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&nl_sixpp=%s',
        'key'       =>  '',
        'code'      =>  'nl_NL',
    ],
    'Pstcd'         => [
        'url'       =>  'http://api.pstcd.nl/%s/?auth_key=%s&sixpp=%s&streetnumber=%s',
        'key'       =>  '',
        'code'      =>  'nl_NL'
    ],

    'Pro6PP_BE'     =>  [
        'url'       =>  'https://api.pro6pp.nl/v1/autocomplete?auth_key=%s&be_fourpp=%s',
        'key'       =>  '',
        'code'      =>  'nl_BE',
    ],

    'Geocodio'      =>  [
        'url'       =>  'https://api.geocod.io/v1/geocode/?q=%s&api_key=%s',
        'key'       =>  '',
        'code'      =>  'en_US',
    ],

    'IdealPostcodes'=>  [
        'url'       =>  'https://api.ideal-postcodes.co.uk/v1/postcodes/%s?api_key=%s',
        'key'       =>  '',
        'code'      =>  'en_GB'
    ],
    'GetAddressIO' =>    [
        'url'       =>  'https://api.getaddress.io/v2/uk/%s?api-key=%s',
        'key'       =>  '',
        'code'      =>  'en_GB'
    ],
    'PostcodesIO'   => [
        'url'       =>  'https://api.postcodes.io/postcodes?q=%s',
        'key'       =>  '',
        'code'      =>  'en_GB',
    ],
    'UkPostcodes'   =>  [
        'url'       =>  'http://uk-postcodes.com/postcode/%s.json',
        'key'       =>  '',
        'code'      =>  'en_GB',
    ],
    'GeoPostcodeOrgUk' => [
        'url'       =>  'http://www.geopostcode.org.uk/api/%s.json',
        'key'       =>  '',
        'code'      =>  'en_GB',
    ],

    'PostcodeApiComAu' => [
        'url'       =>  'http://v0.postcodeapi.com.au/suburbs/%s.json',
        'key'       =>  '',
        'code'      =>  'en_AU'
    ]
];
