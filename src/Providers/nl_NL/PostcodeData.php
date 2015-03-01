<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class PostcodeData extends Provider {
	
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

    public function find($postCode) {}
    public function findByPostcode($postCode){}

    /**
     * @param $postCode
     * @param $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $this->setRequestUrl($this->getRequestUrl().'?postcode='.$postCode.'&streetnumber='.$houseNumber.'&ref=domeinnaam.nl');
        $response = $this->request();

        $address = new Address();
        $address
            ->setStreet($response['details'][0]['street'])
            ->setHouseNo($houseNumber)
            ->setTown($response['details'][0]['city'])
            ->setMunicipality($response['details'][0]['municipality'])
            ->setProvince($response['details'][0]['province'])
            ->setLatitude($response['details'][0]['lat'])
            ->setLongitude($response['details'][0]['lon']);

        return $address;
    }
}