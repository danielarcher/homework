<?php 

namespace Language\Application;

use Language\Application\Resource\ResourceInterface;

class Application
{
	protected $id;

	protected $languages;

	public function __construct(ResourceInterface $resource)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getLanguages()
	{
		return $this->languages;
	}

	public function loadLanguages() {
		$this->languages = $this->resource->getLanguages();
	}
}