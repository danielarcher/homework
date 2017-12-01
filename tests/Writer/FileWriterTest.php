<?php 

use Language\Application\Writer\FileWriter;
use PHPUnit\Framework\TestCase;

class FileWriterTest extends TestCase
{
	public function testWrite()
	{
		$writer = new FileWriter();
		$writer->write('testFile.txt', 'mycontent');

		$this->assertEquals(file_get_contents('testFile.txt'), 'mycontent');
	}

	public function tearDown()
	{
		unlink('testFile.txt');
	}
}