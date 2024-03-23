<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class PostcodeApiNu extends Provider
{
    public function find(string $postCode): Address
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, ''));

        $response = $this->request();

        if (! isset($response['_embedded']['addresses'][0])) {
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

    protected function request()
    {
        try {
            return Http::withHeaders([
                'X-Api-Key' => $this->getApiKey(),
            ])->get($this->getRequestUrl())->json();
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $houseNumber));

        $response = $this->request();

        if (! isset($response['_embedded']['addresses'][0])) {
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
