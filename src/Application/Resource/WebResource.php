<?php 

namespace Language\Application\Resource;

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\LanguageCollection;
use Language\Application\Resource\ResourceInterface;

class WebResource implements ResourceInterface
{
	public function __construct(Config $config, Api $api)
	{
		$this->config = $config;
		$this->api = $api;
	}

	public function getConfig()
	{
		return $this->config;
	}

	public function getApi()
	{
		return $this->api;
	}

	public function getApplications()
	{
		$apps = $this->config->get('system.translated_applications');
		return array_keys($apps);
	}

	public function getLanguages(string $appId)
	{
		$collection = new LanguageCollection();
		$languages = $this->config->get('system.translated_applications')[$appId];

		if (true === empty($languages)) {
			return $collection;
		}

		return $collection->addMany($languages);
	}

	public function getLanguageFile(string $appId, string $language)
	{
		return $this->api->get(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getLanguageFile'
			),
			array(
				'language' => $language
			)
		);
	}

	public function getLanguageCachePath(string $appId, string $language)
	{
		return $this->config->get('system.paths.root') . '/cache/' . $appId. '/' . $language . '.php';
	}
}