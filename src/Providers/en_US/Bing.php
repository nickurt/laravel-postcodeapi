<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Bing extends Provider
{
    public function find(string $postCode): Address
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&'.$options : '';

        $this->setRequestUrl($this->getRequestUrl().'?postalCode='.$postCode.'&key='.$this->getApiKey().$options);

        $response = $this->request();

        if ($response['resourceSets'][0]['estimatedTotal'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['resourceSets'][0]['resources'][0]['address']['locality'])
            ->setLatitude($response['resourceSets'][0]['resources'][0]['point']['coordinates'][0])
            ->setLongitude($response['resourceSets'][0]['resources'][0]['point']['coordinates'][1]);

        if ($municipality = $response['resourceSets'][0]['resources'][0]['address']['adminDistrict2'] ?? null) {
            $address->setMunicipality($municipality);
        }

        if ($province = $response['resourceSets'][0]['resources'][0]['address']['adminDistrict'] ?? null) {
            $address->setProvince($province);
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
