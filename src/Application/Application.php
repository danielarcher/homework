<?php 

namespace Language\Application;

use Language\Application\Discover\LanguageDiscover;

abstract class Application
{
	protected $id;

	protected $languageDiscover;

	public function __construct(string $id, LanguageDiscover $languageDiscover)
	{
		$this->id = $id;
		$this->languageDiscover = $languageDiscover;
	}

	private function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}
}