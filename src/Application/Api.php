<?php 

namespace Language\Application;

use Language\ApiCall;
use Language\Application\Exception\ApiErrorException;

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
        try {
            $result = ApiCall::call($target, $mode, $getParameters, $postParameters);

            return $this->validateResult($result);
        } catch (\Exception $e) {
            $message = sprintf(
                "Error during api call. Arguments: {%s} message {%s}",
                json_encode(func_get_args()),
                $e->getMessage()
                );
            throw new ApiErrorException($message);
        }
    }

    /**
     * validate the result set of apicall
     * @param  mixed $result
     * @return mixed
     */
    public function validateResult($result)
    {
        if ($result === false || !isset($result['status'])) {
            throw new \InvalidArgumentException('Return is empty.');
        }
        
        if ($result['status'] != 'OK') {
            $errorMessage = sprintf(
                'Returned error type[%s] error code[%s].',
                $result['error_type'] ?? '',
                $result['error_code'] ?? ''
            );
            throw new \LogicException($errorMessage);
        }
        
        if (empty($result['data'])) {
            throw new \InvalidArgumentException('Content is empty.');
        }

        return $result['data'];
    }
}
