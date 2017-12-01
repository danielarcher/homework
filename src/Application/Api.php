<?php 

namespace Language\Application;

class Api
{
	public function get($target, $mode, $getParameters, $postParameters)
	{
		$return = ApiCall::call($target, $mode, $getParameters, $postParameters);
		
		if (false === $this->isValidReturn($return)) {
			return false;
		}

		return $return['data'];
	}

	public function isValidReturn($return)
	{
		if ($result === false || !isset($result['status'])) {
			throw new \InvalidArgumentException('Error during the api call: return is empty.');
		}
		
		if ($result['status'] != 'OK') {
			$errorMessage = sprintf('Error in api response: Returned error type[%s] error code[%s].', 
				$result['error_type'] ?? '', 
				$result['error_code'] ?? '');
			throw new \LogicException($errorMessage);
		}
		
		if ($result['data'] === false) {
			throw new \InvalidArgumentException('Error in api response: content is empty.');
		}

		return true;
	}
}