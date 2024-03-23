<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use Illuminate\Support\Facades\Http;
use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\Provider;

class IdealPostcodes extends Provider
{
    protected function request()
    {
        try {
            return Http::get($this->getRequestUrl())->json();
        } catch (\Exception $e) {
            return json_decode($e->getMessage(), true);
        }
    }

    public function find(string $postCode): Address
    {
        $this->setRequestUrl(sprintf($this->getRequestUrl(), $postCode, $this->getApiKey()));

        $response = $this->request();

        if (isset($response['message']) && $response['message'] != 'Success') {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['result'][0]['post_town'])
            ->setStreet($response['result'][0]['line_1'])
            ->setLatitude($response['result'][0]['latitude'])
            ->setLongitude($response['result'][0]['longitude']);

        return $address;
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
