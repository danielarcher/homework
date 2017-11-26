<?php 

namespace Language;

class Applet
{
	private $id;

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

	public function getLanguages()
	{
		$result = ApiCall::call(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getAppletLanguages'
			),
			array('applet' => $this->getId())
		);

		try {
			ApiCallErrorVerifier::checkError($result);
		}
		catch (\Exception $e) {
			throw new \Exception('Getting languages for applet (' . $applet . ') was unsuccessful ' . $e->getMessage());
		}

		return $result['data'];
	}


	/**
	 * Gets a language xml for an applet.
	 * 
	 * @param string $language    The language identifier.
	 *
	 * @return string|false   The content of the language file or false if weren't able to get it.
	 */
	public function getLanguageFile($language)
	{
		$result = ApiCall::call(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getAppletLanguageFile'
			),
			array(
				'applet' => $this->getId(),
				'language' => $language
			)
		);

		try {
			ApiCallErrorVerifier::checkError($result);
		}
		catch (\Exception $e) {
			throw new \Exception('Getting language xml for applet: (' . $applet . ') on language: (' . $language . ') was unsuccessful: '
				. $e->getMessage());
		}

		return $result['data'];
	}

	public function composeFiles()
	{
		echo " Getting > {$this->getId()} language xmls..\n";
		$languages = $this->getLanguages();
		if (empty($languages)) {
			throw new \Exception('There is no available languages for the ' . $this->getId() . ' applet.');
		}
		else {
			echo ' - Available languages: ' . implode(', ', $languages) . "\n";
		}
		$path = Config::get('system.paths.root') . '/cache/flash';
		foreach ($languages as $language) {
			$xmlContent = $this->getLanguageFile($language);
			$xmlFile    = $path . '/lang_' . $language . '.xml';
			FileHandle::save($xmlFile, $xmlContent);
		}
		echo " < {$this->getId()} language xml cached.\n";
	}
}