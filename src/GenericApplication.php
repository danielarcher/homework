<?php 

namespace Language;

class GenericApplication implements ITranslatableApplication
{
	protected $id;

	public function composeFiles()
	{
		echo "[APPLICATION: " . $this->getId() . "]\n";
		$languages = $this->getLanguages();
		foreach ($languages as $language) {
			echo "\t[LANGUAGE: " . $language . "]";
			$content = $this->getLanguageFile($language);
			if (false == $this->generateFile($content, $language)) {
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

	protected function generateFile($content, $language)
	{
		$destination = $this->getLanguageCachePath($language);

		return FileHandle::save($destination, $content);
	}

	protected function getLanguages() {}

	protected function getLanguageFile($language) {}

	protected function getLanguageCachePath($language) {}
}