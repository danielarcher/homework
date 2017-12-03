<?php 

namespace Language\Application;

use Language\Application\Writer\WriterInterface;

class Translator
{
	private $app;

	private $languages;

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

	public function run()
	{
		if (false == count($this->languages)) {
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