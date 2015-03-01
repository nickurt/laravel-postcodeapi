<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class Pro6PP_NL extends Provider {

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
     * @throws \nickurt\PostcodeApi\Exception\MalformedURLException
     */
    public function find($postCode)
    {
        $this->setRequestUrl($this->getRequestUrl().'?auth_key='.$this->getApiKey().'&nl_sixpp='.$postCode);
        $response = $this->request();

        $address = new Address();
        $address
            ->setStreet($response['results'][0]['street'])
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