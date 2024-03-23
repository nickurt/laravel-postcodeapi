<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class Here extends Provider
{
    public function find(string $postCode): Address
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&'.$options : '';

        $this->setRequestUrl($this->getRequestUrl().'?postalCode='.$postCode.'&app_id='.$this->getApiKey().'&app_code='.$this->getApiSecret().'&gen=9'.$options);

        $response = $this->request();

        if (count($response['Response']['View']) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['Response']['View'][0]['Result'][0]['Location']['Address']['City'])
            ->setProvince($response['Response']['View'][0]['Result'][0]['Location']['Address']['State'])
            ->setLatitude($response['Response']['View'][0]['Result'][0]['Location']['DisplayPosition']['Latitude'])
            ->setLongitude($response['Response']['View'][0]['Result'][0]['Location']['DisplayPosition']['Longitude']);

        if ($street = $response['Response']['View'][0]['Result'][0]['Location']['Address']['Street'] ?? null) {
            $address->setStreet($street);
        }

        if ($houseNo = $response['Response']['View'][0]['Result'][0]['Location']['Address']['HouseNumber'] ?? null) {
            $address->setHouseNo($houseNo);
        }

        if ($municipality = $response['Response']['View'][0]['Result'][0]['Location']['Address']['County'] ?? null) {
            $address->setMunicipality($municipality);
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
