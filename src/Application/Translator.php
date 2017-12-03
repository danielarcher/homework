<?php 

namespace Language\Application;

use Language\Application\Writer\WriterInterface;

class Translator
{
	private $app;

	private $languages = array();

	private $writer;

	/**
	 * @param string          $app    
	 * @param WriterInterface $writer 
	 */
	public function __construct(string $app, LanguageCollection $collection, WriterInterface $writer)
	{
		$this->app = $app;
		$this->writer = $writer;
		$this->languages = $collection;
	}

	/**
	 * add a Language
	 * @param Language $language [description]
	 */
	public function addLanguage(Language $language) {
		array_push($this->languages, $language);
	}

	public function run()
	{
		if (empty($this->languages)) {
			return false;
		}

		foreach ($this->languages as $language)
		{
			$this->writer->write($language->getCacheFile(), $language->getContent());
		}
	}

    /**
     * @return mixed
     */
    public function getApp()
    {
        return $this->app;
    }
}