<?php 

namespace Language\Application;

class LanguageCollection implements \IteratorAggregate
{
    private $languages = array();

    public function add($language)
    {
        array_push($this->languages, $language);
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->languages);
    }
}