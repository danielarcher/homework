<?php 

namespace Language\Application\Resource;

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Resource\ResourceInterface;

class AppletResource implements ResourceInterface
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

	public function getLanguages(string $appId)
	{
		return $this->api->get(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getAppletLanguages'
			),
			array('applet' => $appId)
		);
	}

	public function getLanguageFile(string $appId, string $language)
	{
		return $this->api->get(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getAppletLanguageFile'
			),
			array(
				'applet' => $appId,
				'language' => $language
			)
		);
	}

	public function getLanguageCachePath(string $language)
	{
		return $this->config->get('system.paths.root') . '/cache/flash/lang_' . $language . '.xml';
	}
}