<?php 

namespace Language\Application;

class LanguageCollection implements \IteratorAggregate, \Countable
{
    private $languages = array();

    public function add($language)
    {
        $this->languages[] = $language;

        return $this;
    }

    public function addMany(array $languages)
    {
        foreach ($languages as $lang) {
            $this->add($lang);
        }
        
        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->languages);
    }

    public function count()
    {
        return count($this->languages);
    }
}