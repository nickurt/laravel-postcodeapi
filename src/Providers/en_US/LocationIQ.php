<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class LocationIQ extends Provider
{
    public function find(string $postCode): Address
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&'.$options : '';

        $this->setRequestUrl($this->getRequestUrl().'?q='.$postCode.'&statecode=1&addressdetails=1&format=json&key='.$this->getApiKey().$options);

        $response = $this->request();

        if (isset($response['error'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response[0]['address']['city'] ?? $response[0]['address']['town'])
            ->setLatitude($response[0]['lat'])
            ->setLongitude($response[0]['lon']);

        if ($municipality = $response[0]['address']['county'] ?? $response[0]['address']['state'] ?? null) {
            $address->setMunicipality($municipality);
        }

        if ($province = $response[0]['address']['state'] ?? null) {
            $address->setProvince($province);
        }

        return $address;
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
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }
}
