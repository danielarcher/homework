<?php 

namespace Language\Handler;

class ApiErrorHandler
{
	public static function checkError($result)
	{
		// Error during the api call.
		if ($result === false || !isset($result['status'])) {
			throw new \InvalidArgumentException('Error during the api call');
		}
		// Wrong response.
		if ($result['status'] != 'OK') {
			throw new \LogicException('Wrong response: '
				. (!empty($result['error_type']) ? 'Type(' . $result['error_type'] . ') ' : '')
				. (!empty($result['error_code']) ? 'Code(' . $result['error_code'] . ') ' : '')
				. ((string)$result['data']));
		}
		// Wrong content.
		if ($result['data'] === false) {
			throw new \InvalidArgumentException('Wrong content!');
		}
	}
}