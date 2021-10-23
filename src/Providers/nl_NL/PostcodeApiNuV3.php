<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use Illuminate\Support\Arr;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exception\NotSupportedException;
use nickurt\PostcodeApi\Providers\Provider;

class PostcodeApiNuV3 extends Provider
{
    public function find(string $postCode): Address
    {
        throw new NotSupportedException('Cannot search with postcode only');
    }

    protected function request()
    {
        $response = $this->getHttpClient()->request('GET', $this->getRequestUrl(), [
            'headers' => [
                'X-Api-Key' => $this->getApiKey()
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function findByPostcode(string $postCode): Address
    {
        return $this->find($postCode);
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        // Format postcode into 1234AB format
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        // Extract number from house number
        $houseNumber = preg_replace('/^\s*(\d+).*$/', '\1', $houseNumber);

        // Send request
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $houseNumber));

        // Handle response
        $response = $this->request();

        // Check for a street
        if (!Arr::has($response, 'street')) {
            // Postcode / housenumber combination not found
            return new Address();
        }

        // Found it :)
        return (new Address())
            ->setStreet(Arr::get($response, 'street'))
            ->setHouseNo((string)Arr::get($response, 'number'))
            ->setTown(Arr::get($response, 'city'))
            ->setMunicipality(Arr::get($response, 'municipality'))
            ->setProvince(Arr::get($response, 'province'))
            // They're [long, lat]!
            ->setLongitude(Arr::get($response, 'location.coordinates.0'))
            ->setLatitude(Arr::get($response, 'location.coordinates.1'));
    }
}
