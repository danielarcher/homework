<?php 

namespace Language\Application\Factory;

use Language\Application\Exception\LanguageCacheFileNullException;
use Language\Application\Exception\LanguageFileNotFoundException;
use Language\Application\Language;
use Language\Application\Resource\ResourceInterface;

class LanguageFactory
{
	protected $app;

	protected $resource;

	protected $language;

	/**
	 * @param string            $appId      
	 * @param string            $languageId 
	 * @param ResourceInterface $resource   
	 */
	public function __construct(string $appId, string $languageId, ResourceInterface $resource)
	{
		$this->app = $appId;
		$this->resource = $resource;
		$this->language = $languageId;
	}

	/**
	 * Create a new language class
	 * @return Language
	 */
	public function create()
	{
		$languageContent = $this->resource->getLanguageFile($this->app, $this->language);
		$cacheFile = $this->resource->getLanguageCachePath($this->app, $this->language);

		if (true === empty($languageContent)) {
			throw new LanguageFileNotFoundException("Language file not found for [{$this->app}/{$this->language}]", 1);
		}

		if (true === is_null($cacheFile)) {
			throw new LanguageCacheFileNullException("Language file not found for [{$this->app}/{$this->language}]", 1);
		}

		return new Language($this->language, $languageContent, $cacheFile);
	}
}