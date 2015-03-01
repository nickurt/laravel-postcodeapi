<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use \nickurt\PostcodeApi\Providers\Provider;
use \nickurt\PostcodeApi\Entity\Address;

class PostcodeApiNu extends Provider {
	
	protected $apiKey;
	protected $requestUrl;

    /**
     * @return mixed
     */
	protected function request()
	{
		$client = $this->getHttpClient();
		$client->setDefaultOption('headers', ['Api-Key' => $this->getApiKey()]);
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
		$this->setRequestUrl($this->getRequestUrl().'/'.$postCode);
		$response = $this->request();

		$address = new Address();
		$address
			->setStreet($response['resource']['street'])
			->setTown($response['resource']['town'])
			->setMunicipality($response['resource']['municipality'])
			->setProvince($response['resource']['province'])
			->setLatitude($response['resource']['latitude'])
			->setLongitude($response['resource']['longitude']);

		return $address;
	}

	public function findByPostcode($postCode) {}
	public function findByPostcodeAndHouseNumber($postCode, $houseNumber) {}
}