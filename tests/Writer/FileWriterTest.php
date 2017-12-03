<?php 

use Language\Application\Exception\UnableToWriteFileException;
use Language\Application\Writer\FileWriter;
use PHPUnit\Framework\TestCase;

class FileWriterTest extends TestCase
{
	public function setUp()
	{
		$this->file = 'testFolder' . rand() . '/testFile.txt';
		$this->folder = dirname($this->file);
		$this->content = 'my content';
	}

	public function testWrite()
	{
		$writer = new FileWriter();
		$writer->write($this->file, $this->content);

		$this->assertEquals(file_get_contents($this->file), $this->content);
	}

	public function testUnableToWrite()
	{
		$this->expectException(UnableToWriteFileException::class);

		$writer = new FileWriter();
		$writer->write($this->file, $this->content);
		chmod($this->folder, 0000);
		$writer->write($this->file, $this->content);
	}

	public function tearDown()
	{
		chmod($this->folder, 0700);
		if (file_exists($this->file)) {
			unlink($this->file);
		}
		rmdir($this->folder);
	}
}