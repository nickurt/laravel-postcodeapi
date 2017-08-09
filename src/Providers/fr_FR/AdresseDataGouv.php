<?php

namespace nickurt\postcodeapi\Providers\fr_FR;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class AdresseDataGouv extends Provider
{
    protected $apiKey;
    protected $requestUrl;

    /**
     * @return mixed
     */
    protected function request()
    {
        $client = $this->getHttpClient();
        $response = $client->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, ''));
        $response = $this->request();

        $address = new Address();
        $address
            ->setTown($response['features'][0]['properties']['city'])
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }

    public function findByPostcode($postCode)
    {
    }

    /**
     * @param $postCode
     * @param $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), urlencode($houseNumber), $postCode));
        $response = $this->request();

        $address = new Address();
        $address
            ->setHouseNo($response['features'][0]['properties']['housenumber'])
            ->setStreet($response['features'][0]['properties']['street'])
            ->setTown($response['features'][0]['properties']['city'])
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }
}
