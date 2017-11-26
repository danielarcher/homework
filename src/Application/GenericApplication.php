<?php 

namespace Language\Application;

use Language\Handler\FileHandler;

class GenericApplication implements ITranslatableApplication
{
	protected $id;

	protected $logger;

	public function setLogger($logger)
	{
		$this->logger = $logger;
	}

	public function composeFiles()
	{
		$languages = $this->getLanguages();
		foreach ($languages as $language) {
			if (false == $this->generateFile($language)) {
				throw new \LogicException('Unable to generate language file!');
			}
		}
	}
	public function __construct($id)
	{
		$this->setId($id);
	}

	private function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	protected function generateFile($language)
	{
		$content = $this->getLanguageFile($language);
		$destination = $this->getLanguageCachePath($language);

		return FileHandler::save($destination, $content);
	}

	protected function getLanguages() {}

	protected function getLanguageFile($language) {}

	protected function getLanguageCachePath($language) {}
}