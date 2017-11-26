<?php 

use Language\Application\FilesGenerator;
use Language\Application\WebApplication;
use PHPUnit\Framework\TestCase;

class FilesGeneratorTest extends TestCase
{
	public function testComposeFiles()
	{
		$generator = new FilesGenerator(new WebApplication('portal'));
		$this->assertTrue($generator->composeFiles());
	}

	public function testConstructError()
	{
		$this->expectException(TypeError::class);
		$generator = new FilesGenerator();
	}

	public function testApplicationConstructError()
	{
		$this->expectException(TypeError::class);
		$generator = new FilesGenerator(new WebApplication());
	}
}