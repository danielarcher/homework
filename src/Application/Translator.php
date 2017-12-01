<?php 

namespace Language\Application;

use Language\Application\Writer\WriterInterface;

class Translator
{
	private $app;

	private $languages = array();

	public function __construct(string $app, WriterInterface $writer)
	{
		$this->app = $app;
		$this->writer = $writer;
	}

	public function addLanguage(Language $language) {
		array_push($this->languages, $language);
	}

	public function run()
	{
		foreach ($this->languages as $language)
		{
			$this->writer->write($language->getCacheFile(), $language->getContent());
		}
	}
}