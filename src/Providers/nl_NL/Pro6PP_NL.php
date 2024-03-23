<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Pro6PP_NL extends Provider
{
    protected function request()
    {
        return Http::get($this->getRequestUrl())->json();
    }

    public function find(string $postCode): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $this->getApiKey(), $postCode));

        $response = $this->request();

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        return $this->toAddress($response);
    }

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $this->getApiKey(), $postCode).'&streetnumber='.$houseNumber);

        $response = $this->request();

        if (isset($response['status']) && $response['status'] == 'error') {
            return new Address();
        }

        return $this->toAddress($response)
            ->setHouseNo($houseNumber);
    }

    protected function toAddress(array $response): Address
    {
        $address = new Address();
        $address
            ->setStreet($response['results'][0]['street'])
            ->setTown($response['results'][0]['city'])
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province']);

        if (! empty($latitude = $response['results'][0]['lat']) && ! empty($longitude = $response['results'][0]['lng'])) {
            $address->setLatitude($latitude)
                ->setLongitude($longitude);
        }

        return $address;
    }
}
