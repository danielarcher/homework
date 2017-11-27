<?php 

namespace Language\Application;

use Language\Application\ITranslatableApplication;
use Language\Handler\FileHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;

class FilesGenerator
{
	protected $logger;

	protected $application;

	/**
	 * Create new file generator
	 * 
	 * @param ITranslatableApplication $application 
	 */
	public function __construct(ITranslatableApplication $application)
	{
		$this->application = $application;
		$this->setLogger(new Logger('Default'));
	}

	/**
	 * @return ITranslatableApplication
	 */
	public function getApplication()
	{
		return $this->application;
	}

	/**
	 * return or create logger
	 * 
	 * @return LoggerInterface 
	 */
	private function getLogger()
	{
		return $this->logger;
	}

	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	/**
	 * Generate the files for the listed languages
	 * @return bool
	 */
	public function composeFiles()
	{
		$this->getLogger()->debug('--Application: ' . $this->getApplication()->getId());
		$languages = $this->getApplicationLanguages();
		foreach ($languages as $language) {
			$this->getLogger()->debug('--Language: ' . $language);
			if (false == $this->generateFile($language)) {
				throw new \LogicException('Unable to generate language file!');
			}
		}

		return true;
	}
	
	/**
	 * Generate the files for the specific language
	 * @param  string $language
	 * @return bool
	 */
	private function generateFile(string $language)
	{
		$content = $this->getApplication()->getLanguageFile($language);
		$destination = $this->getApplication()->getLanguageCachePath($language);

		return FileHandler::save($destination, $content);
	}

	/**
	 * Get the required languages to generate files
	 * @return array|false
	 */
	private function getApplicationLanguages()
	{
		return $this->getApplication()->getLanguages();
	}

}