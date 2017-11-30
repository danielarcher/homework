<?php 

namespace Language\Application\Translator;

use Language\Application\Translator\TranslatableInterface;
use Language\Application\Writer\WriterInterface;
use Psr\Log\LoggerInterface;

class TranslationGenerator
{
	protected $application;

	protected $writer;

	/**
	 * Create new file generator
	 * 
	 * @param TranslatableInterface $application 
	 */
	public function __construct(TranslatableInterface $application, WriterInterface $writer)
	{
		$this->application = $application;
		$this->writer = $writer;
	}

	/**
	 * Generate the files for the listed languages
	 * @return bool|void
	 */
	public function composeFiles()
	{
		$languages = $this->application->getLanguages();

		foreach ($languages as $language) {
			$this->generateFile($language);
		}

		return true;
	}
	
	/**
	 * Generate the files for the specific language
	 * @param  string $language
	 * @return void
	 */
	private function generateFile(string $language)
	{
		$content = $this->application->getLanguageFile($language);
		$destination = $this->application->getLanguageCachePath($language);

		$this->writer->write($destination, $content);
	}

}