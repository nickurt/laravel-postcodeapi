<?php

namespace nickurt\postcodeapi\Providers\nl_BE;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class Pro6PP_BE extends Provider {
	
    protected $apiKey;
    protected $requestUrl;

    /**
     * @return mixed
     */
    protected function request()
    {
        $client = $this->getHttpClient();
        $response = $client->get($this->getRequestUrl())->json();

        return $response;
    }

    /**
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $this->setRequestUrl($this->getRequestUrl().'?auth_key='.$this->getApiKey().'&be_fourpp='.$postCode);
        $response = $this->request();

        $address = new Address();
        $address
            ->setTown($response['results'][0]['city'])
            ->setMunicipality($response['results'][0]['municipality'])
            ->setProvince($response['results'][0]['province'])
            ->setLatitude($response['results'][0]['lat'])
            ->setLongitude($response['results'][0]['lng']);

        return $address;
    }

    public function findByPostcode($postCode) {}
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber) {}
}