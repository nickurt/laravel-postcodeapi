<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Algolia extends Provider
{
    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function find(string $postCode): Address
    {
        $this->setOptions(array_merge($this->getOptions(), [
            'query' => $postCode,
            'hitsPerPage' => 1,
        ]));

        $response = $this->request();

        if ($response['nbHits'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['hits'][0]['locale_names']['default'][0])
            ->setProvince($response['hits'][0]['administrative'][0])
            ->setLatitude($response['hits'][0]['_geoloc']['lat'])
            ->setLongitude($response['hits'][0]['_geoloc']['lng']);

        if ($municipality = $response['hits'][0]['county']['default'][0] ?? $response['hits'][0]['city']['default'][0] ?? null) {
            $address->setMunicipality($municipality);
        }

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('POST', $this->getRequestUrl(), [
            'headers' => [
                'X-Algolia-Application-Id' => $this->getApiSecret(),
                'X-Algolia-API-Key' => $this->getApiKey(),
            ],
            'body' => json_encode($this->getOptions())
        ]);

        return json_decode($response->getBody(), true);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $this->setOptions(array_merge($this->getOptions(), [
            'query' => $postCode . '+' . $houseNumber,
            'hitsPerPage' => 1,
        ]));

        $response = $this->request();

        if ($response['nbHits'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['hits'][0]['city']['default'][0])
            ->setProvince($response['hits'][0]['administrative'][0])
            ->setLatitude($response['hits'][0]['_geoloc']['lat'])
            ->setLongitude($response['hits'][0]['_geoloc']['lng']);

        if ($municipality = $response['hits'][0]['county']['default'][0] ?? $response['hits'][0]['city']['default'][0] ?? null) {
            $address->setMunicipality($municipality);
        }

        return $address;
    }
}
