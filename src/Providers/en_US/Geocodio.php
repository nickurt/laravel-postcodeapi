<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Geocodio extends Provider
{
    public function find(string $postCode): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $this->getApiKey()));

        $response = $this->request();

        if (count($response['results']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setMunicipality($response['results'][0]['address_components']['state'])
            ->setTown($response['results'][0]['address_components']['city'])
            ->setLatitude($response['results'][0]['location']['lat'])
            ->setLongitude($response['results'][0]['location']['lng']);

        if ($street = $response['results'][0]['address_components']['formatted_street'] ?? null) {
            $address->setMunicipality($street);
        }

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
