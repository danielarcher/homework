<?php 

namespace Language;

class Applet extends GenericApplication
{
	protected function getLanguages()
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
	protected function getLanguageFile($language)
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

	protected function getLanguageCachePath($language)
	{
		return Config::get('system.paths.root') . '/cache/flash/lang_' . $language . '.xml';
	}

}