<?php 

namespace Language\Application\Factory;

use Language\Application\Factory\LanguageFactory;
use Language\Application\Resource\ResourceInterface;
use Language\Application\Translator;
use Language\Application\Writer\WriterInterface;

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

		$translator = new Translator($this->app, $this->writer);
		foreach ($languagesResource as $languageId) {
			$translator->addLanguage($this->createLanguage($languageId));
		}

		return $translator;
	}

	public function createLanguage($languageId)
	{
		return (new LanguageFactory($this->app, $languageId, $this->resource))->create();
	}

}