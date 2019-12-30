<?php

namespace nickurt\PostcodeApi;

use Closure;
use Illuminate\Foundation\Application;
use nickurt\PostcodeApi\Concerns\Provider;

class ProviderManager
{
    /** @var \Illuminate\Foundation\Application */
    protected $app;

    /** @var array */
    protected $providers = [];

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $provider
     * @return \nickurt\PostcodeApi\Concerns\Provider
     * @throws \nickurt\PostcodeApi\Exception\InvalidArgumentException
     */
    public function create(string $provider)
    {
        $config = $this->app['config']["postcodeapi.{$provider}"];

        if (isset($this->providers[$provider])) {
            //
        } else {
            $method = 'create' . ucfirst($provider) . 'Driver';

            if (method_exists($this, $method)) {
                return $this->{$method}($config);
            }

            throw new \nickurt\PostcodeApi\Exception\InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
        }
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createAddresseDataGouvDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\fr_FR\AddresseDataGouv());
    }

    /**
     * @param \nickurt\PostcodeApi\Concerns\Provider $driver
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function driver(Provider $driver)
    {
        return $driver;
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createAlgoliaDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Algolia())->setApiKey($config['key'])->setApiKey($config['secret']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createApiPostcodeDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\ApiPostcode())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createBingDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Bing())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createGeoPostcodeOrgUkDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_GB\GeoPostcodeOrgUk());
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createGeocodioDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Geocodio())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createGetAddressIODriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_GB\GetAddressIO())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createGoogleDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Google())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createHereDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Here())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createIdealPostcodesDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_GB\IdealPostcodes())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createLocationIQDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\LocationIQ())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createMapboxDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Mapbox())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createNationaalGeoRegisterDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister());
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createOpenCageDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\OpenCage())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcoDeDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\nl_NL\PostcoDe());
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodeApiComAuDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_AU\PostcodeApiComAu());
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodeApiNuDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNu())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodeDataDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\nl_NL\PostcodeData());
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodeNLDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\PostcodeNL())->setApiKey($config['key'])->setApiSecret($config['secret']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodesIODriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_GB\PostcodesIO());
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodesNLDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\PostcodesNL())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPro6PP_BEDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_BE\Pro6PP_BE())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPro6PP_NLDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\Pro6PP_NL())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createTomTomDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\TomTom())->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createUkPostcodesDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_GB\UkPostcodes());
    }

    /**
     * @param string $provider
     * @param Closure $closure
     * @return $this
     */
    public function extend(string $provider, Closure $closure)
    {
        $this->providers[$provider] = $closure;

        return $this;
    }
}
