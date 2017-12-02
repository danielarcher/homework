<?php 

namespace Language\Application\Factory;

use Language\Application\Language;
use Language\Application\Resource\ResourceInterface;

class LanguageFactory
{
	protected $app;

	protected $resource;

	protected $language;

	/**
	 * Create new file generator
	 * 
	 * @param TranslatableInterface $application 
	 */
	public function __construct(string $appId, string $languageId, ResourceInterface $resource)
	{
		$this->app = $appId;
		$this->resource = $resource;
		$this->language = $languageId;
	}

	/**
	 * Generate the files for the listed languages
	 * @return bool|void
	 */
	public function create()
	{
		$languageContent = $this->resource->getLanguageFile($this->app, $this->language);
		$cacheFile = $this->resource->getLanguageCachePath($this->app, $this->language);

		return new Language($this->language, $languageContent, $cacheFile);
	}
}