<?php 

namespace Language\Application;

use Language\Handler\FileHandler;

abstract class Application
{
	protected $id;

	public function __construct($id)
	{
		$this->setId($id);
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