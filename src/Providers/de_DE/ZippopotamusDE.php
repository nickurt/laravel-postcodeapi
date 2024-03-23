<?php

namespace nickurt\PostcodeApi\Providers\de_DE;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class ZippopotamusDE extends Provider
{
    public function find(string $postCode): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, ''));

        $response = $this->request();

        if (isset($response['places']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['places'][0]['place name'])
            ->setProvince($response['places'][0]['state'])
            ->setLatitude($response['places'][0]['latitude'])
            ->setLongitude($response['places'][0]['longitude']);

        return $address;
    }

    protected function request()
    {
        return Http::get($this->getRequestUrl())->json();
    }

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }
}
