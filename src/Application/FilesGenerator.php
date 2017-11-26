<?php 

namespace Language\Application;

use Language\Handler\FileHandler;

class FilesGenerator
{
	protected $id;

	protected $logger;

	protected $application;

    /**
     * @return mixed
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param mixed $application
     *
     * @return self
     */
    public function setApplication($application)
    {
        $this->application = $application;

        return $this;
    }

	public function __construct($application)
	{
		$this->application = $application;
	}

	public function setLogger($logger)
	{
		$this->logger = $logger;
	}

	public function composeFiles()
	{
		$languages = $this->getApplication()->getLanguages();
		foreach ($languages as $language) {
			if (false == $this->generateFile($language)) {
				throw new \LogicException('Unable to generate language file!');
			}
		}
	}
	
	protected function generateFile($language)
	{
		$content = $this->getApplication()->getLanguageFile($language);
		$destination = $this->getApplication()->getLanguageCachePath($language);

		return FileHandler::save($destination, $content);
	}

}