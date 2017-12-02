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

    /**
     * @codeCoverageIgnore
     * @return ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->languages);
    }

    /**
     * @codeCoverageIgnore
     * @return integer
     */
    public function count()
    {
        return count($this->languages);
    }
}