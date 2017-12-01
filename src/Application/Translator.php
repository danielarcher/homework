<?php 

namespace Language

class Translator
{
	private $app;

	private $languages = array();

	public function __construct(string $app, WriterInterface $writer)
	{
		$this->app = $app;
	}

	public function addLanguage(Language $language) {
		array_push($this->languages, $language);
	}

	public function run()
	{
		foreach ($languages as $language)
		{
			$writer->write($language->get($id), $language->getContent());
		}
	}
}