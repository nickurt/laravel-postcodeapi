<?php

namespace nickurt\PostcodeApi\Providers;

use DateInterval;
use nickurt\PostcodeApi\Concerns\Adapter;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class CacheProvider extends AbstractAdapter
{
    /** @var Adapter */
    protected $adapter;

    /** @var CacheInterface */
    protected $cache;

    /** @var null|int|DateInterval */
    protected $ttl = 3600;

    /**
     * @param Adapter $adapter
     * @param CacheInterface $cache
     * @param null|int|DateInterval $ttl
     */
    public function __construct(Adapter $adapter, CacheInterface $cache, $ttl = 3600)
    {
        $this->adapter = $adapter;
        $this->cache = $cache;
        $this->ttl = $ttl;
    }

    /**
     * @inheritDoc
     */
    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    /**
     * @inheritDoc
     */
    public function find($postCode)
    {
        try {
            if ($this->cache->has($cacheKey = $this->getCacheKey())) {
                return $this->cache->get($cacheKey);
            }

            $response = $this->adapter->find($postCode);

            $this->cache->set($cacheKey, $response, $this->ttl);

            return $response;
        } catch (InvalidArgumentException $e) {
            //
        }

        return $this->adapter->find($postCode);
    }

    /**
     * @return string
     */
    protected function getCacheKey()
    {
        return strtolower(sprintf('%s-%s-%s',
            basename(str_replace('\\', '/', get_class($this))),
            debug_backtrace()[1]['function'],
            implode('-', debug_backtrace()[1]['args'])
        ));
    }

    /**
     * @inheritDoc
     */
    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        try {
            if ($this->cache->has($cacheKey = $this->getCacheKey())) {
                return $this->cache->get($cacheKey);
            }

            $response = $this->adapter->findByPostcodeAndHouseNumber($postCode, $houseNumber);

            $this->cache->set($cacheKey, $response, $this->ttl);

            return $response;
        } catch (InvalidArgumentException $e) {
            //
        }

        return $this->adapter->findByPostcodeAndHouseNumber($postCode, $houseNumber);
    }

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }
}
