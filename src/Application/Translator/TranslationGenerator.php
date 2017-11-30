<?php 

namespace Language\Application\Translator;

use Language\Application\Translator\TranslatableInterface;
use Language\Application\Writer\WriterInterface;
use Psr\Log\LoggerInterface;

class TranslationGenerator
{
	protected $logger;

	protected $application;

	protected $writer;

	/**
	 * Create new file generator
	 * 
	 * @param TranslatableInterface $application 
	 */
	public function __construct(TranslatableInterface $application, WriterInterface $writer, LoggerInterface $logger)
	{
		$this->application = $application;
		$this->logger = $logger;
		$this->writer = $writer;
	}

	/**
	 * Generate the files for the listed languages
	 * @return bool|void
	 */
	public function composeFiles()
	{
		$this->logger->debug('--Application: ' . $this->application->getId());
		$languages = $this->application->getLanguages();

		foreach ($languages as $language) {
			$this->logger->debug('--Language: ' . $language);
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

		if (false === $this->writer->write($destination, $content)) {
			throw new \LogicException(sprintf("Unable to save language [%s/%s] file!", 
				$this->application->getId(), 
				$language
			));
		}
	}

}