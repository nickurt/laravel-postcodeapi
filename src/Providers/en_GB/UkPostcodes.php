<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as UkPostcodesClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class UkPostcodes extends AbstractAdapter
{
    /** @var UkPostcodesClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'http://uk-postcodes.com/postcode/%s.json';

    /**
     * @param UkPostcodesClient $client
     */
    public function __construct(UkPostcodesClient $client)
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
     * @param $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $response = json_decode($this->client->get(sprintf($this->getRequestUrl(), $postCode))->getBody(), true);

        $address = new Address();
        $address
            ->setLatitude($response['geo']['lat'])
            ->setLongitude($response['geo']['lng']);

        return $address;
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        throw new \nickurt\PostcodeApi\Exceptions\NotSupportedException();
    }
}
