<?php 

namespace Language;

class Language
{
	private $id;

	private $content;

	public function __construct($id, $content)
	{
		$this->id = $id;
		$this->content = $content;
	}
}