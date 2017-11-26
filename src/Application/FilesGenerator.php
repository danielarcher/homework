<?php 

namespace Language\Application;

use Language\Application\ITranslatableApplication;
use Language\Handler\FileHandler;
use Psr\Log\LoggerInterface;

class FilesGenerator
{
	protected $id;

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
	}

	/**
	 * @return ITranslatableApplication
	 */
	public function getApplication()
	{
		return $this->application;
	}

	public function setLogger(LoggerInterface $logger)
	{
		$this->logger = $logger;
	}

	public function composeFiles()
	{
		$this->logger->debug('--Application: ' . $this->getApplication()->getId());
		$languages = $this->getApplication()->getLanguages();
		foreach ($languages as $language) {
			$this->logger->debug('--Language: ' . $language);
			if (false == $this->generateFile($language)) {
				throw new \LogicException('Unable to generate language file!');
			}
		}
	}
	
	protected function generateFile(string $language)
	{
		$content = $this->getApplication()->getLanguageFile($language);
		$destination = $this->getApplication()->getLanguageCachePath($language);

		return FileHandler::save($destination, $content);
	}

}