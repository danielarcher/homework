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
			if ($this->getLanguageFile($language)) {
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

		return $this->generateFile($languageResponse, $language);
	}

	private function generateFile($languageApiResponse, $language)
	{
		$destination = $this->getLanguageCachePath($this->getId()) . $language . '.php';

		return FileHandle::save($destination, $languageApiResponse['data']);
	}

	public function getLanguageCachePath($language)
	{
		return Config::get('system.paths.root') . '/cache/' . $this->getId(). '/';
	}
}