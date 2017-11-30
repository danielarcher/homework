<?php 

namespace Language\Application\Discover;

use Language\ApiCall;
use Language\Handler\ApiErrorHandler;

class LanguageDiscover
{
	public function getFile(string $action, array $parameters)
	{
		$result = ApiCall::call(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => $action
			),
			$parameters
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