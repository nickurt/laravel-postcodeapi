<?php

namespace nickurt\PostcodeApi\Providers;

use \GuzzleHttp\Client as Client;

abstract class Provider implements ProviderInterface
{
	protected $apiKey;
	protected $requestUrl;

	protected $httpClient;

	public function __construct()
	{

		$this->setHttpClient(new Client());
	}

	public function setHttpClient(Client $client)
	{
		$this->httpClient = $client;

		return $this;
	}

	public function getHttpClient()
	{
		return $this->httpClient;
	}

	public function setApiKey($apiKey)
	{
		$this->apiKey = $apiKey;
	}

	public function setRequestUrl($url)
	{
		$this->requestUrl = $url;
	}

	public function getApiKey()
	{
		return $this->apiKey;
	}

	public function getRequestUrl()
	{
		return $this->requestUrl;
	}

	protected abstract function request();
	protected abstract function find($postCode);
	protected abstract function findByPostcode($postCode);
	protected abstract function findByPostcodeAndHouseNumber($postCode, $houseNumber);
}