<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class OpenCage extends Provider
{
    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function find(string $postCode): Address
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&'.$options : '';

        $this->setRequestUrl($this->getRequestUrl().'?q='.$postCode.'&key='.$this->getApiKey().$options);

        $response = $this->request();

        if ($response['total_results'] < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['results'][0]['components']['city'] ?? $response['results'][0]['components']['suburb'])
            ->setMunicipality($response['results'][0]['components']['country'])
            ->setProvince($response['results'][0]['components']['state'])
            ->setLatitude($response['results'][0]['geometry']['lat'])
            ->setLongitude($response['results'][0]['geometry']['lng']);

        return $address;
    }

    protected function request()
    {
        return Http::get($this->getRequestUrl())->json();
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }
}
