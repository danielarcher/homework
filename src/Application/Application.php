<?php 

namespace Language\Application;

use Language\Application\Discover\LanguageDiscover;

abstract class Application
{
	protected $id;

	protected $languages;

	public function __construct(string $id, LanguageDiscover $languageDiscover)
	{
		$this->id = $id;
		$this->languageDiscover = $languageDiscover;
		$this->languages = $this->loadLanguages();
	}

	public function getId()
	{
		return $this->id;
	}

	public function getLanguages()
	{
		return $this->languages;
	}

	public function loadLanguages() {}
}