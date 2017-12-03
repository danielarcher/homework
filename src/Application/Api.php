<?php 

namespace Language\Application;

use Language\ApiCall;

class Api
{
	/**
	 * make the static call to the old api class
	 * @param  string $target         
	 * @param  string $mode           
	 * @param  array  $getParameters  
	 * @param  array  $postParameters 
	 * @return mixed
	 */
	public function get(string $target, string $mode, array $getParameters, array $postParameters)
	{
		$result = ApiCall::call($target, $mode, $getParameters, $postParameters);
		
		return $this->validateResult($result);
	}

	/**
	 * validate the result set of apicall
	 * @param  mixed $result
	 * @return mixed        
	 */
	public function validateResult($result)
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
		
		if (empty($result['data'])) {
			throw new \InvalidArgumentException('Error in api response: content is empty.');
		}

		return $result['data'];
	}
}