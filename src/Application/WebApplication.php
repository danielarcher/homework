<?php 

namespace Language\Application;

use Language\ApiCall;
use Language\Application\Application;
use Language\Application\ITranslatableApplication;
use Language\Config;
use Language\Handler\ApiErrorHandler;

class WebApplication extends Application implements ITranslatableApplication
{
	/**
	 * return the necessary languages to translate
	 * @return array
	 */
	public function getLanguages()
	{
		$applications = Config::get('system.translated_applications');
		return $applications[$this->getId()];
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
				'action' => 'getLanguageFile'
			),
			array('language' => $language)
		);

		try {
			ApiErrorHandler::checkError($result);
		}
		catch (\Exception $e) {
			throw new \Exception('Error during getting language file: (' . $this->getId() . '/' . $language . ') ' . $e->getMessage());
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
		return Config::get('system.paths.root') . '/cache/' . $this->getId(). '/' . $language . '.php';
	}
}