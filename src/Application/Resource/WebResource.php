<?php 

namespace Language\Application\Resource;

class WebResource implements ResourceInterface
{
	public function __construct($config, $api)
	{
		$this->config = $config;
		$this->api = $api;
	}

	public function getLanguages($appId)
	{
		return $this->config->get('system.translated_applications')[$app->getId()];
	}

	public function getLanguageFile($appId, $language)
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
		)
	}
}