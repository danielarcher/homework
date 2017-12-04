<?php 

namespace Language\Application;

class Config
{
    /**
     * make the static call to the old class
     * @param  string $key
     * @return mixed
     */
    public function get(string $key)
    {
        return \Language\Config::get($key);
    }
}
