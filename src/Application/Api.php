<?php 

namespace Language\Application;

class Api
{
	public function get($target, $mode, $getParameters, $postParameters)
	{
		return ApiCall::call($target, $mode, $getParameters, $postParameters);
	}
}