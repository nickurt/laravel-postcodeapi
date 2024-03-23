<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\Provider;

class PostcoDe extends Provider
{
    public function find(string $postCode): Address
    {
        throw new NotSupportedException();
    }

    protected function request()
    {
        try {
            return Http::get($this->getRequestUrl())->json();
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    public function findByPostcode(string $postCode): Address
    {
        throw new NotSupportedException();
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $houseNumber));

        $response = $this->request();

        if (array_key_exists('error', $response)) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setHouseNo($houseNumber)
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setMunicipality($response['municipality'])
            ->setProvince($response['province'])
            ->setLatitude($response['lat'])
            ->setLongitude($response['lng']);

        return $address;
    }
}
