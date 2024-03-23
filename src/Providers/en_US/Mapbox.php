<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\Provider;

class Mapbox extends Provider
{
    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function find(string $postCode): Address
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&'.$options : '';

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode).'?access_token='.$this->getApiKey().$options);

        $response = $this->request();

        if (count($response['features']) < 1) {
            return new Address();
        }

        $components = collect($response['features'][0]['context'])->mapWithKeys(function ($item, $value) {
            return [explode('.', $item['id'])[0] => $item];
        })->toArray();

        $address = new Address();
        $address
            ->setTown($components['place']['text'])
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        if ($province = $components['region']['text'] ?? null) {
            $address->setProvince($province);
        }

        return $address;
    }

    protected function request()
    {
        return Http::get($this->getRequestUrl())->json();
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        throw new NotSupportedException();
    }
}
