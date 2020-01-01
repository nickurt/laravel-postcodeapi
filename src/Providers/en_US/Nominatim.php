<?php

namespace nickurt\PostcodeApi\Providers\en_US;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as NominatimClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class Nominatim extends AbstractAdapter
{
    /** @var NominatimClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://nominatim.openstreetmap.org/search';

    /**
     * @param NominatimClient $client
     */
    public function __construct(NominatimClient $client)
    {
        $this->client = $client;
    }

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

        $response = json_decode($this->client->get($this->getRequestUrl() . '?format=jsonv2&q=' . $postCode . '&addressdetails=1&limit=1' . $options)->getBody(), true);

        if (count($response) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response[0]['address']['city'] ?? $response[0]['address']['suburb'] ?? null)
            ->setMunicipality($response[0]['address']['county'] ?? $response[0]['address']['suburb'] ?? $response[0]['address']['state_district'] ?? null)
            ->setProvince($response[0]['address']['state'])
            ->setLatitude($response[0]['lat'])
            ->setLongitude($response[0]['lon']);

        return $address;
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new \nickurt\PostcodeApi\Exceptions\NotSupportedException();
    }
}
