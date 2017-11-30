<?php 

namespace Language\Application;

abstract class Application
{
	protected $id;

	public function __construct(string $id)
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