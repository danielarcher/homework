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
			$errorMessage = sprintf('Wrong response: Type(%) Code(%) %', 
				$result['error_type'], 
				$result['error_code'], 
				$result['data']);
			throw new \LogicException($errorMessage);
		}
		// Wrong content.
		if ($result['data'] === false) {
			throw new \InvalidArgumentException('Wrong content!');
		}
	}
}