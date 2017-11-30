<?php 

namespace Language\Application;

use Language\ApiCall;
use Language\Application\Application;
use Language\Application\Translator\TranslatableInterface;
use Language\Config;
use Language\Handler\ApiErrorHandler;

class AppletApplication extends Application implements TranslatableInterface
{
	/**
	 * return the necessary languages to translate
	 * @return array
	 */
	public function loadLanguages()
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
		$parameters = array(
			'applet' => $this->getId(),
			'language' => $language
		);
		return $this->languageDiscover->getFile('getAppletLanguageFile', $parameters);
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