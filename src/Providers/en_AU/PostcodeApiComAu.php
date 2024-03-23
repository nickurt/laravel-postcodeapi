<?php

namespace nickurt\PostcodeApi\Providers\en_AU;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\Provider;

class PostcodeApiComAu extends Provider
{
    public function find(string $postCode): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode));

        $response = $this->request();

        if (count($response) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response[0]['name'])
            ->setMunicipality($response[0]['state']['name'])
            ->setLatitude($response[0]['latitude'])
            ->setLongitude($response[0]['longitude']);

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
        throw new NotSupportedException();
    }
}
