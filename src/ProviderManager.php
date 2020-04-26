<?php

namespace nickurt\PostcodeApi;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use nickurt\PostcodeApi\Concerns\Adapter;

class ProviderManager
{
    /** @var \Illuminate\Contracts\Foundation\Application */
    protected $app;

    /** @var array */
    protected $providers = [];

    /**
     * @param \Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $provider
     * @return \nickurt\PostcodeApi\Concerns\Provider
     * @throws \nickurt\PostcodeApi\Exceptions\InvalidArgumentException
     */
    public function create(string $provider)
    {
        /** @var array $config */
        $config = $this->app['config']['postcodeapi'];

        $config = array_key_exists('providers', $config)
            ? (array_key_exists($provider, $config["providers"]) ? $config['providers'][$provider] : '')
            : (array_key_exists($provider, $config) ? $config[$provider] : '');

        if (isset($this->providers[$provider])) {
            return $this->providers[$provider]($this->app, $config);
        } else {
            if (isset($config['alias']) && class_exists($config['alias'])) {
                $class = new $config['alias'](new \nickurt\PostcodeApi\Http\Guzzle6HttpClient());

                if (isset($config['key'])) {
                    $class->setApiKey($config['key']);
                }

                if (isset($config['secret'])) {
                    $class->setApiKey($config['secret']);
                }

                return $this->driver($class);
            } else {
                $method = 'create' . ucfirst($config['driver'] ?? $provider) . 'Driver';

                if (method_exists($this, $method)) {
                    return $this->{$method}($config);
                }
            }

            throw new \nickurt\PostcodeApi\Exceptions\InvalidArgumentException(sprintf('Unable to use the provider "%s"', $provider));
        }
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createAdresseDataGouvDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\fr_FR\AdresseDataGouv(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param \nickurt\PostcodeApi\Concerns\Adapter $driver
     * @return \nickurt\PostcodeApi\Providers\Provider
     */
    protected function driver(Adapter $driver)
    {
        return new \nickurt\PostcodeApi\Providers\Provider($driver);
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createAlgoliaDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Algolia(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key'])->setApiKey($config['secret']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createApiPostcodeDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\ApiPostcode(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createBingDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Bing(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createGeoPostcodeOrgUkDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_GB\GeoPostcodeOrgUk(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createGeocodioDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Geocodio(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createGetAddressIODriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_GB\GetAddressIO(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createGoogleDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Google(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createHereDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Here(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createIdealPostcodesDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_GB\IdealPostcodes(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createLocationIQDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\LocationIQ(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createMapboxDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\Mapbox(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createNationaalGeoRegisterDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\nl_NL\NationaalGeoRegister(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createNominatimDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_US\Nominatim(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createOpenCageDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\OpenCage(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPhotonDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_US\Photon(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPickPointDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\ru_RU\PickPoint(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcoDeDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\nl_NL\PostcoDe(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodeApiComAuDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_AU\PostcodeApiComAu(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodeApiNuDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\PostcodeApiNu(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodeDataDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\nl_NL\PostcodeData(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodeNLDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\PostcodeNL(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key'])->setApiSecret($config['secret']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodesIODriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_GB\PostcodesIO(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPostcodesNLDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\PostcodesNL(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPro6PP_BEDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_BE\Pro6PP_BE(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createPro6PP_NLDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\nl_NL\Pro6PP_NL(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createTomTomDriver(array $config)
    {
        return $this->driver((new \nickurt\PostcodeApi\Providers\en_US\TomTom(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()))->setApiKey($config['key']));
    }

    /**
     * @param array $config
     * @return \nickurt\PostcodeApi\Concerns\Provider
     */
    protected function createUkPostcodesDriver(array $config)
    {
        return $this->driver(new \nickurt\PostcodeApi\Providers\en_GB\UkPostcodes(new \nickurt\PostcodeApi\Http\Guzzle6HttpClient()));
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
