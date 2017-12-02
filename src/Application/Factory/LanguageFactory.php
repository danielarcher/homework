<?php 

namespace Language\Application\Factory;

use Language\Application\Language;
use Language\Application\Resource\ResourceInterface;
use Language\Application\Translator;
use Language\Application\Writer\WriterInterface;
use Psr\Log\LoggerInterface;

class LanguageFactory
{
	protected $app;

	protected $resource;

	/**
	 * Create new file generator
	 * 
	 * @param TranslatableInterface $application 
	 */
	public function __construct(string $app, ResourceInterface $resource)
	{
		$this->app = $app;
		$this->resource = $resource;
	}

	/**
	 * Generate the files for the listed languages
	 * @return bool|void
	 */
	public function create()
	{
		$languageContent = $this->resource->getLanguageFile($this->app, $languageId);
		$cacheFile = $this->resource->getLanguageCachePath($this->app, $languageId);

		return new Language($languageId, $languageContent, $cacheFile);
	}
}