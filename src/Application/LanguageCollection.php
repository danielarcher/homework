<?php 

namespace Language\Application;

use Language\Application\Language;

class LanguageCollection implements \IteratorAggregate, \Countable
{
    private $languages = array();

    /**
     * add new language in collection
     * @param mixed $language
     * @return  LanguageCollection
     */
    public function add(Language $language)
    {
        $this->languages[] = $language;

        return $this;
    }

    /**
     * add a array of objects in the collection
     * @param array $languages
     * @return  LanguageCollection
     */
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

    public function count()
    {
        return count($this->languages);
    }

    public function getLanguagesNames()
    {
        $resultSet = array();
        foreach ($this as $language) {
            $resultSet[] = $language->getId();
        }
        return $resultSet;
    }
}