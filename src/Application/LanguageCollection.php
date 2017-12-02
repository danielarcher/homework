<?php 

namespace Language\Application;

class LanguageCollection implements \IteratorAggregate
{
    private $languages = array();

    public function add($language)
    {
        $this->languages[] = $language;

        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->languages);
    }
}