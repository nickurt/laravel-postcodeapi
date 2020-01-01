<?php

namespace nickurt\PostcodeApi\Providers\en_AU;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Exceptions\NotSupportedException;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as PostcodeApiComAuClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class PostcodeApiComAu extends AbstractAdapter
{
    /** @var PostcodeApiComAuClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'http://v0.postcodeapi.com.au/suburbs/%s.json';

    /**
     * @param PostcodeApiComAuClient $client
     */
    public function __construct(PostcodeApiComAuClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $postCode
     * @return mixed
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
        $response = json_decode($this->client->get(sprintf($this->getRequestUrl(), $postCode))->getBody(), true);

        if (count($response) < 1) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response[0]['name'])
            ->setMunicipality($response[0]['state']['name'])
            ->setLatitude($response[0]['latitude'])
            ->setLongitude($response[0]['longitude']);

        return $address;
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
