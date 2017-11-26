<?php 

namespace Language;

class Applet
{
	private $appletId;

	public function __construct($appletId)
	{
		$this->setAppletId($appletId);
	}

	public function setAppletId($id)
	{
		$this->appletId = $id;
	}

	public function getAppletId()
	{
		return $this->appletId;
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
			array('applet' => $this->getAppletId())
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
				'applet' => $this->getAppletId(),
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

	public function generateXmlFiles()
	{
		echo " Getting > {$this->getAppletId()} language xmls..\n";
		$languages = $this->getLanguages();
		if (empty($languages)) {
			throw new \Exception('There is no available languages for the ' . $this->getAppletId() . ' applet.');
		}
		else {
			echo ' - Available languages: ' . implode(', ', $languages) . "\n";
		}
		$path = Config::get('system.paths.root') . '/cache/flash';
		foreach ($languages as $language) {
			$xmlContent = $this->getLanguageFile($language);
			$xmlFile    = $path . '/lang_' . $language . '.xml';
			LanguageBatchBo::saveFile($xmlFile, $xmlContent);
		}
		echo " < {$this->getAppletId()} language xml cached.\n";
	}
}