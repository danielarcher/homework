<?php 

namespace Language\Application;

class Config
{
	public function get(string $key)
	{
		return \Language\Config::get($key);
	}
}