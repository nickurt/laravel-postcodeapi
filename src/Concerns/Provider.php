<?php

namespace nickurt\PostcodeApi\Concerns;

use nickurt\PostcodeApi\Entity\Address;

interface Provider
{
    /**
     * @param string $postCode
     * @return Address
     */
    public function find($postCode);

    /**
     * @param string $postCode
     * @return Address
     */
    public function findByPostcode($postCode);

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber);
}
