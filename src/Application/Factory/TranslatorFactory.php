<?php 

namespace Language\Application\Factory;

use Language\Application\Resource\ResourceInterface;
use Language\Application\Writer\WriterInterface;
use Psr\Log\LoggerInterface;
use Language\Translator;

class TranslatorFactory
{
	protected $app;

	protected $resource;

	protected $writer;

	/**
	 * Create new file generator
	 * 
	 * @param TranslatableInterface $application 
	 */
	public function __construct(string $app, ResourceInterface $resource, WriterInterface $writer)
	{
		$this->app = $app;
		$this->resource = $resource;
		$this->writer = $writer;
	}

	/**
	 * Generate the files for the listed languages
	 * @return bool|void
	 */
	public function create()
	{
		$languagesResource = $this->resource->getLanguages($this->app);

		$translator = new Translator($this->app, $languages, $this->writer);
		foreach ($languagesResource as $languageId) {
			$translator->addLanguage($this->getLanguage($languageId));
		}

		return $translator;
	}

	public function createLanguage($languageId)
	{
		$languageContent = $this->resource->getLanguageFile($this->app, $languageId);
		return new Language($languageId, $languageContent);
	}

}