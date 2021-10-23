<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class NationaalGeoRegister extends Provider
{
    public function find(string $postCode): Address
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl($this->getRequestUrl() . '?q=postcode:' . $postCode . '&rows=1');

        $response = $this->request();

        if (count($response['response']['docs']) < 1) {
            return new Address();
        };

        [$lng, $lat] = explode(' ', substr($response['response']['docs'][0]['centroide_ll'], 6, -1));

        $address = new Address();
        $address
            ->setStreet($response['response']['docs'][0]['straatnaam'])
            ->setTown($response['response']['docs'][0]['woonplaatsnaam'])
            ->setMunicipality($response['response']['docs'][0]['gemeentenaam'])
            ->setProvince($response['response']['docs'][0]['provincienaam'])
            ->setLatitude($lat)
            ->setLongitude($lng);

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl($this->getRequestUrl() . '?q=postcode:' . $postCode . '%20and%20housenumber:' . $houseNumber . '&rows=1');

        $response = $this->request();

        if (count($response['response']['docs']) < 1) {
            return new Address();
        };

        [$lng, $lat] = explode(' ', substr($response['response']['docs'][0]['centroide_ll'], 6, -1));

        $address = new Address();
        $address
            ->setHouseNo((string)$response['response']['docs'][0]['huisnummer'])
            ->setStreet($response['response']['docs'][0]['straatnaam'])
            ->setTown($response['response']['docs'][0]['woonplaatsnaam'])
            ->setMunicipality($response['response']['docs'][0]['gemeentenaam'])
            ->setProvince($response['response']['docs'][0]['provincienaam'])
            ->setLatitude($lat)
            ->setLongitude($lng);

        return $address;
    }
}
