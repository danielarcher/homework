<?php 

namespace Language\Application\Discover;

use Language\ApiCall;
use Language\Application\Translator\TranslatableInterface;
use Language\Handler\ApiErrorHandler;

class LanguageDiscover
{
	public function getFile(string $language)
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

	public function getAppletFile(TranslatableInterface $applet, string $language)
	{
		$result = ApiCall::call(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getAppletLanguageFile'
			),
			array(
				'applet' => $applet->getId(),
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
}