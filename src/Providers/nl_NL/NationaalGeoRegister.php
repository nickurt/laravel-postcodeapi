<?php

namespace nickurt\postcodeapi\Providers\nl_NL;

use nickurt\PostcodeApi\Entity\Address;
use nickurt\PostcodeApi\Providers\AbstractAdapter;

class NationaalGeoRegister extends AbstractAdapter
{
    /** @var string */
    protected $requestUrl = 'http://geodata.nationaalgeoregister.nl/locatieserver/v3/free';

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
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = $this->get(
            $this->getRequestUrl() . '?q=postcode:' . $postCode . '&rows=1'
        );

        if (count($response['response']['docs']) < 1) {
            return new Address();
        };

        [$lng, $lat] = explode(' ', substr($response['response']['docs'][0]['centroide_ll'], 6, -1));

        $address = new Address();
        $address
            ->setStreet($response['response']['docs'][0]['straatnaam'])
            ->setTown($response['response']['docs'][0]['woonplaatsnaam'])
            ->setMunicipality($response['response']['docs'][0]['gemeentenaam'])
            ->setProvince($response['response']['docs'][0]['provincienaam'])
            ->setLatitude($lat)
            ->setLongitude($lng);

        return $address;
    }

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        $postCode = strtoupper(preg_replace('/\s+/', '', $postCode));

        $response = $this->get(
            $this->getRequestUrl() . '?q=postcode:' . $postCode . '%20and%20housenumber:' . $houseNumber . '&rows=1'
        );

        if (count($response['response']['docs']) < 1) {
            return new Address();
        };

        [$lng, $lat] = explode(' ', substr($response['response']['docs'][0]['centroide_ll'], 6, -1));

        $address = new Address();
        $address
            ->setHouseNo((string)$response['response']['docs'][0]['huisnummer'])
            ->setStreet($response['response']['docs'][0]['straatnaam'])
            ->setTown($response['response']['docs'][0]['woonplaatsnaam'])
            ->setMunicipality($response['response']['docs'][0]['gemeentenaam'])
            ->setProvince($response['response']['docs'][0]['provincienaam'])
            ->setLatitude($lat)
            ->setLongitude($lng);

        return $address;
    }
}
