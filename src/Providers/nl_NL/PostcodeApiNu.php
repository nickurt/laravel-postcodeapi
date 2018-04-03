<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class PostcodeApiNu extends Provider
{
    protected $apiKey;
    protected $requestUrl;

    /**
     * @return mixed
     */
    protected function request()
    {
        $client = $this->getHttpClient();
        $response = $client->request('GET', $this->getRequestUrl(), [
            'headers' => [
                'X-Api-Key' => $this->getApiKey()
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
    
    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, ''));
        $response = $this->request();

        if (!isset($response['_embedded']['addresses'][0])) {
            /**
             * Postcode / housenumber combination not found
             */
            return new Address();
        }

        $address = new Address();
        $address
            ->setStreet($response['_embedded']['addresses'][0]['street'])
            ->setTown($response['_embedded']['addresses'][0]['city']['label'])
            ->setMunicipality($response['_embedded']['addresses'][0]['municipality']['label'])
            ->setProvince($response['_embedded']['addresses'][0]['province']['label'])
            ->setLatitude($response['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][1])
            ->setLongitude($response['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][0]);

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
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $houseNumber));
        $response = $this->request();

        if (!isset($response['_embedded']['addresses'][0])) {
            /**
             * Postcode / housenumber combination not found
             */
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($response['_embedded']['addresses'][0]['number'].$response['_embedded']['addresses'][0]['addition'])
            ->setStreet($response['_embedded']['addresses'][0]['street'])
            ->setTown($response['_embedded']['addresses'][0]['city']['label'])
            ->setMunicipality($response['_embedded']['addresses'][0]['municipality']['label'])
            ->setProvince($response['_embedded']['addresses'][0]['province']['label'])
            ->setLatitude($response['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][1])
            ->setLongitude($response['_embedded']['addresses'][0]['geo']['center']['wgs84']['coordinates'][0]);

        return $address;
    }
}
