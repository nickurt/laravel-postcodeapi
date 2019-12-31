<?php

namespace nickurt\PostcodeApi\Concerns;

interface Adapter
{
    /**
     * @param string $postCode
     * @return \nickurt\PostcodeApi\Entity\Address
     */
    public function find($postCode);

    /**
     * @param string $postCode
     * @return \nickurt\PostcodeApi\Entity\Address
     */
    public function findByPostcode($postCode);

    /**
     * @param string $postCode
     * @param string $houseNumber
     * @return \nickurt\PostcodeApi\Entity\Address
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber);
}
