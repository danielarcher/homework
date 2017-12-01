<?php 

namespace Language\Application\Resource;

interface ResourceInterface
{
	public function __construct(Config $config, Api $api)

	public function getLanguages(string $appId)

	public function getLanguageFile(string $appId, string $language)

	public function getLanguageCachePath(string $language)
	
}