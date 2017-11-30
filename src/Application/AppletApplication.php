<?php 

namespace Language\Application;

use Language\ApiCall;
use Language\Application\Application;
use Language\Application\TranslatableInterface;
use Language\Config;
use Language\Handler\ApiErrorHandler;

class AppletApplication extends Application implements TranslatableInterface
{
	/**
	 * return the necessary languages to translate
	 * @return array
	 */
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
			ApiErrorHandler::checkError($result);
		}
		catch (\Exception $e) {
			throw new \Exception('Getting languages for applet (' . $this->getId() . ') was unsuccessful ' . $e->getMessage());
		}

		return $result['data'];
	}

	/**
	 * return the languageFile to be created
	 * @param  string $language 
	 * @return string
	 */
	public function getLanguageFile(string $language)
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
			ApiErrorHandler::checkError($result);
		}
		catch (\Exception $e) {
			throw new \Exception('Getting language xml for applet: (' . $this->getId() . ') on language: (' . $language . ') was unsuccessful: '
				. $e->getMessage());
		}

		return $result['data'];
	}

	/**
	 * return the path for the language cache
	 * @param  string $language
	 * @return string
	 */
	public function getLanguageCachePath(string $language)
	{
		return Config::get('system.paths.root') . '/cache/flash/lang_' . $language . '.xml';
	}

}