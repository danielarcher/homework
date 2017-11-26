<?php 

namespace Language\Application;

use Language\ApiCall;
use Language\Config;
use Language\Handler\ApiErrorHandler;

class WebApplication extends GenericApplication
{
	protected function getLanguages()
	{
		$applications = Config::get('system.translated_applications');
		return $applications[$this->getId()];
	}

	protected function getLanguageFile($language)
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

	protected function getLanguageCachePath($language)
	{
		return Config::get('system.paths.root') . '/cache/' . $this->getId(). '/' . $language . '.php';
	}
}