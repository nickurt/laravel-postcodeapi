<?php

namespace nickurt\PostcodeApi\Providers\en_GB;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Http\Guzzle6HttpClient as PostcodesIOClient;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class PostcodesIO extends AbstractAdapter
{
    /** @var PostcodesIOClient */
    protected $client;

    /** @var string */
    protected $requestUrl = 'https://api.postcodes.io/postcodes?q=%s';

    /**
     * @param PostcodesIOClient $client
     */
    public function __construct(PostcodesIOClient $client)
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
     * @param string $postCode
     * @return Address
     */
    public function find($postCode)
    {
        $response = json_decode($this->client->get(sprintf($this->getRequestUrl(), $postCode))->getBody(), true);

        if (!is_array($response['result'])) {
            return new Address();
        }

        $address = new Address();
        $address
            ->setTown($response['result'][0]['region'])
            ->setLatitude($response['result'][0]['latitude'])
            ->setLongitude($response['result'][0]['longitude']);

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
