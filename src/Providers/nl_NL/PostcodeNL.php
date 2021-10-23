<?php

namespace nickurt\PostcodeApi\Providers\nl_NL;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class PostcodeNL extends Provider
{
    protected function request()
    {
        $client = $this->getHttpClient();

        $response = $client->request('GET', $this->getRequestUrl(), [
            'auth' => [
                $this->getApiKey(), $this->getApiSecret()
            ]
        ]);

        return json_decode($response->getBody(), true);
    }

    public function find(string $postCode): Address
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    public function findByPostcode(string $postCode): Address
    {
        throw new \nickurt\PostcodeApi\Exception\NotSupportedException();
    }

    public function findByPostcodeAndHouseNumber(string $postCode, string $houseNumber): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $houseNumber));
        $response = $this->request();

        $address = new Address();
        $address
            ->setStreet($response['street'])
            ->setTown($response['city'])
            ->setHouseNo($response['houseNumber'])
            ->setMunicipality($response['municipality'])
            ->setProvince($response['province'])
            ->setLatitude($response['latitude'])
            ->setLongitude($response['longitude']);

        return $address;
    }
}
