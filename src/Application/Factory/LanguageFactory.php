<?php 

namespace Language\Application\Factory;

use Language\Application\Exception\LanguageCacheFileNullException;
use Language\Application\Exception\LanguageFileNotFoundException;
use Language\Application\Language;
use Language\Application\Resource\ResourceInterface;

class LanguageFactory
{
	protected $resource;

	/**
	 * @param string            $appId      
	 * @param string            $languageId 
	 * @param ResourceInterface $resource   
	 */
	public function __construct(ResourceInterface $resource)
	{
		$this->resource = $resource;
	}

	/**
	 * Create a new language class
	 * @return Language
	 */
	public function create(string $appId, string $languageId)
	{
		$languageContent = $this->resource->getLanguageFile($appId, $languageId);
		$cacheFile = $this->resource->getLanguageCachePath($appId, $languageId);

		if (true === empty($languageContent)) {
			throw new LanguageFileNotFoundException("Language file not found for [{$appId}/{$languageId}]", 1);
		}

		if (true === is_null($cacheFile)) {
			throw new LanguageCacheFileNullException("Language file not found for [{$appId}/{$languageId}]", 1);
		}

		return new Language($languageId, $languageContent, $cacheFile);
	}
}