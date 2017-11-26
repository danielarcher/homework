<?php 

namespace Language\Application;

use Language\ApiCall;
use Language\Application\Application;
use Language\Application\ITranslatableApplication;
use Language\Config;
use Language\Handler\ApiErrorHandler;

class AppletApplication extends Application implements ITranslatableApplication
{
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
			ApiErrorHandler::checkError($result);
		}
		catch (\Exception $e) {
			throw new \Exception('Getting language xml for applet: (' . $applet . ') on language: (' . $language . ') was unsuccessful: '
				. $e->getMessage());
		}

		return $result['data'];
	}

	public function getLanguageCachePath($language)
	{
		return Config::get('system.paths.root') . '/cache/flash/lang_' . $language . '.xml';
	}

}