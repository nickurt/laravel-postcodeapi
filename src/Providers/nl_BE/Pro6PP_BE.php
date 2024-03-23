<?php

namespace nickurt\PostcodeApi\Providers\nl_BE;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Pro6PP_BE extends Provider
{
    public function find(string $postCode): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $this->getApiKey(), $postCode));

        $response = $this->request();

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['results'][0]['city'])
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province'])
            ->setLatitude($response['results'][0]['lat'])
            ->setLongitude($response['results'][0]['lng']);

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
