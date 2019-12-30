<?php

namespace nickurt\postcodeapi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;

class Mapbox extends \nickurt\PostcodeApi\Providers\AbstractProvider
{
    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $requestUrl = 'https://api.mapbox.com/geocoding/v5/mapbox.places/%s.json';

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

        $response = $this->get(sprintf($this->getRequestUrl(), $postCode) . '?access_token=' . $this->getApiKey() . $options);

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

    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param $apiKey
     * @return $this
     */
    public function setApiKey($apiKey)
    {
        $this->apiKey = $apiKey;

        return $this;
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
