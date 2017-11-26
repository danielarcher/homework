<?php 

namespace Language\Application;

use Language\ApiCall;
use Language\Application\Application;
use Language\Application\ITranslatableApplication;
use Language\Config;
use Language\Handler\ApiErrorHandler;

class WebApplication extends Application implements ITranslatableApplication
{
	public function getLanguages()
	{
		$applications = Config::get('system.translated_applications');
		return $applications[$this->getId()];
	}

	public function getLanguageFile(string $language)
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
			ApiErrorHandler::checkError($languageResponse);
		}
		catch (\Exception $e) {
			throw new \Exception('Error during getting language file: (' . $this->getId() . '/' . $language . ') ' . $e->getMessage());
		}

		return $languageResponse['data'];
	}

	public function getLanguageCachePath(string $language)
	{
		return Config::get('system.paths.root') . '/cache/' . $this->getId(). '/' . $language . '.php';
	}
}