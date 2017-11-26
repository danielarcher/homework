<?php 

namespace Language;

class Application
{
	private $id;

	public function __construct($id)
	{
		$this->setId($id);
	}

	private function setid($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function composeFiles()
	{
		echo "[APPLICATION: " . $this->getId() . "]\n";
		$languages = $this->getLanguages();
		foreach ($languages as $language) {
			echo "\t[LANGUAGE: " . $language . "]";
			$content = $this->getLanguageFile($language);
			if ($this->generateFile($content, $language)) {
				echo " OK\n";
			}
			else {
				throw new \Exception('Unable to generate language file!');
			}
		}
	}

	public function getLanguages()
	{
		$applications = Config::get('system.translated_applications');
		return $applications[$this->getId()];
	}

	public function getLanguageFile($language)
	{
		$languageResponse = ApiCall::call(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getLanguageFile'
			),
			array('language' => $language)
		);

		try {
			ApiCallErrorVerifier::checkError($languageResponse);
		}
		catch (\Exception $e) {
			throw new \Exception('Error during getting language file: (' . $this->getId() . '/' . $language . ')');
		}

		return $languageResponse['data'];
	}

	private function generateFile($content, $language)
	{
		$destination = $this->getLanguageCachePath($language);

		return FileHandle::save($destination, $content);
	}

	private function getLanguageCachePath($language)
	{
		return Config::get('system.paths.root') . '/cache/' . $this->getId(). '/' . $language . '.php';
	}
}