<?php 

namespace Language\Handler;

class ApiErrorHandler
{
	public static function checkError($result)
	{
		// Error during the api call.
		if ($result === false || !isset($result['status'])) {
			throw new \InvalidArgumentException('Error during the api call: return is empty.');
		}
		// Wrong response.
		if ($result['status'] != 'OK') {
			$errorMessage = sprintf('Error in api response: Returned error type[%s] error code[%s].', 
				$result['error_type'] ?? '', 
				$result['error_code'] ?? '');
			throw new \LogicException($errorMessage);
		}
		// Wrong content.
		if ($result['data'] === false) {
			throw new \InvalidArgumentException('Error in api response: content is empty.');
		}
	}
}