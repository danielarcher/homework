<?php 

namespace Language\Application\Translator;

use Language\Application\Resource\ResourceInterface;
use Language\Application\Writer\WriterInterface;
use Psr\Log\LoggerInterface;

class TranslationGenerator
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
	public function composeFiles()
	{
		$languages = $this->resource->getLanguages($this->app);
		foreach ($languages as $language) {
			$this->writeFile($language);
		}

		return true;
	}
	
	/**
	 * Generate the files for the specific language
	 * @param  string $language
	 * @return void
	 */
	private function writeFile($language)
	{
		return $this->writer->write(
			$this->resource->getLanguageCachePath($this->app, $language), 
			$this->resource->getLanguageFile($this->app, $language)
		);
	}

}