<?php 

namespace Language\Application\Writer;

interface WriterInterface
{
	public function write($name, $content);
}