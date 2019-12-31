<?php

namespace nickurt\PostcodeApi\Providers;

use \nickurt\PostcodeApi\Concerns\Adapter;

class Provider implements \nickurt\PostcodeApi\Concerns\Provider
{
    /** @var \nickurt\PostcodeApi\Concerns\Adapter */
    protected $adapter;

    /**
     * @param \nickurt\PostcodeApi\Concerns\Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @inheritDoc
     */
    public function find($postCode)
    {
        return $this->getAdapter()->find($postCode);
    }

    /**
     * @return \nickurt\PostcodeApi\Concerns\Adapter
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @inheritDoc
     */
    public function findByPostcode($postCode)
    {
        return $this->getAdapter()->findByPostcode($postCode);
    }

    /**
     * @inheritDoc
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        return $this->getAdapter()->findByPostcodeAndHouseNumber($postCode, $houseNumber);
    }
}
