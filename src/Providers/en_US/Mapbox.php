<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\Provider;

class Mapbox extends Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $options = strlen($options = http_build_query($this->getOptions())) > 1 ? '&' . $options : '';

        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode) . '?access_token=' . $this->getApiKey() . $options);

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
            ->setProvince($components['region']['text'] ?? null)
            ->setLatitude($response['features'][0]['geometry']['coordinates'][1])
            ->setLongitude($response['features'][0]['geometry']['coordinates'][0]);

        return $address;
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl());

        return json_decode($response->getBody(), true);
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new NotSupportedException();
    }
}
