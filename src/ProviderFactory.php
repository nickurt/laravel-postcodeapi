<?php

namespace nickurt\PostcodeApi;

class ProviderFactory {

	public static function create($provider)
	{
		$configInformation = \Config::get('postcodeapi')[$provider];

		$providerClass = 'nickurt\\PostcodeApi\\Providers\\'.$configInformation['code'].'\\'.$provider;

		$class = new $providerClass;
		$class->setApiKey($configInformation['key']);
		$class->setRequestUrl($configInformation['url']);

		return $class;
	}
}