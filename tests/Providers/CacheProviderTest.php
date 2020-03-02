<?php

namespace nickurt\PostcodeApi\tests\Providers;

class CacheProviderTest extends \nickurt\PostcodeApi\tests\TestCase
{
    /** @var \nickurt\PostcodeApi\Providers\CacheProvider */
    protected $cacheProvider;

    /** @var \nickurt\PostcodeApi\tests\Providers\StubProvider */
    protected $stubProvider;

    /** @test */
    public function it_can_get_the_correct_values_for_find_a_valid_postal_code()
    {
        $this->assertFalse($this->cacheProvider->getCache()->has('cacheprovider-find-2345bc'));
        $this->assertFalse($this->cacheProvider->getCache()->has('cacheprovider-find-3456cd'));
        $this->assertFalse($this->cacheProvider->getCache()->has('cacheprovider-find-4567de'));

        $requests = [
            $this->cacheProvider->find('2345BC'),
            $this->cacheProvider->find('3456CD'),
            $this->cacheProvider->find('4567DE'),
            $this->cacheProvider->find('3456CD'),
            $this->cacheProvider->find('2345BC'),
        ];

        $this->assertFalse($this->cacheProvider->getCache()->has('cacheprovider-find-1234ab'));

        $this->assertTrue($this->cacheProvider->getCache()->has('cacheprovider-find-2345bc'));
        $this->assertTrue($this->cacheProvider->getCache()->has('cacheprovider-find-3456cd'));
        $this->assertTrue($this->cacheProvider->getCache()->has('cacheprovider-find-4567de'));

        $this->assertInstanceOf(\nickurt\PostcodeApi\Entity\Address::class, $this->cacheProvider->find('2345BC'));
        $this->assertInstanceOf(\nickurt\PostcodeApi\Entity\Address::class, $this->cacheProvider->find('3456CD'));
        $this->assertInstanceOf(\nickurt\PostcodeApi\Entity\Address::class, $this->cacheProvider->find('4567DE'));

        $this->assertSame(5, count($requests));
        $this->assertSame(3, $this->stubProvider->counter);
    }

    /** @test */
    public function it_can_get_the_correct_values_for_find_by_postcode_and_house_number_a_valid_postal_code()
    {
        $this->assertFalse($this->cacheProvider->getCache()->has('cacheprovider-findbypostcodeandhousenumber-2345bc-5'));
        $this->assertFalse($this->cacheProvider->getCache()->has('cacheprovider-findbypostcodeandhousenumber-3456cd-6'));
        $this->assertFalse($this->cacheProvider->getCache()->has('cacheprovider-findbypostcodeandhousenumber-4567de-7'));

        $requests = [
            $this->cacheProvider->findByPostcodeAndHouseNumber('2345BC', 5),
            $this->cacheProvider->findByPostcodeAndHouseNumber('3456CD', 6),
            $this->cacheProvider->findByPostcodeAndHouseNumber('4567DE', 7),
            $this->cacheProvider->findByPostcodeAndHouseNumber('3456CD', 6),
            $this->cacheProvider->findByPostcodeAndHouseNumber('2345BC', 5),
        ];

        $this->assertFalse($this->cacheProvider->getCache()->has('cacheprovider-findbypostcodeandhousenumber-1234ab-4'));

        $this->assertTrue($this->cacheProvider->getCache()->has('cacheprovider-findbypostcodeandhousenumber-2345bc-5'));
        $this->assertTrue($this->cacheProvider->getCache()->has('cacheprovider-findbypostcodeandhousenumber-3456cd-6'));
        $this->assertTrue($this->cacheProvider->getCache()->has('cacheprovider-findbypostcodeandhousenumber-4567de-7'));

        $this->assertInstanceOf(\nickurt\PostcodeApi\Entity\Address::class, $this->cacheProvider->findByPostcodeAndHouseNumber('2345BC', 5));
        $this->assertInstanceOf(\nickurt\PostcodeApi\Entity\Address::class, $this->cacheProvider->findByPostcodeAndHouseNumber('3456CD', 6));
        $this->assertInstanceOf(\nickurt\PostcodeApi\Entity\Address::class, $this->cacheProvider->findByPostcodeAndHouseNumber('4567DE', 7));

        $this->assertSame(5, count($requests));
        $this->assertSame(3, $this->stubProvider->counter);
    }

    public function setUp(): void
    {
        $this->cacheProvider = (new \nickurt\PostcodeApi\Providers\CacheProvider(
            $this->stubProvider = (new \nickurt\PostcodeApi\tests\Providers\StubProvider()), new \Cache\Adapter\PHPArray\ArrayCachePool()
        ));
    }
}

class StubProvider extends \nickurt\PostcodeApi\Providers\AbstractAdapter
{
    public $counter = 0;

    public function findByPostcode($postCode)
    {
        return $this->find($postCode);
    }

    public function find($postCode)
    {
        $this->counter++;

        return (new \nickurt\PostcodeApi\Entity\Address());
    }

    public function findByPostcodeAndHouseNumber($postCode, $houseNumber)
    {
        return $this->find($postCode);
    }
}
