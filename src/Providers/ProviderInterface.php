<?php

namespace nickurt\PostcodeApi\Providers;

interface ProviderInterface
{
    public function find($postCode);

    public function findByPostcode($postCode);

    public function findByPostcodeAndHouseNumber($postCode, $houseNumber);
}
