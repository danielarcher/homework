<?php 

use Language\Application\Exception\UnableToWriteFileException;
use Language\Application\Writer\FileWriter;
use PHPUnit\Framework\TestCase;

class FileWriterTest extends TestCase
{
	public function setUp()
	{
		$this->file = 'testFile.txt';
		$this->folder = 'testFolder' . rand();
		$this->content = 'my content';

		mkdir($this->folder);
		chmod($this->folder, 0700);
	}

	public function testWrite()
	{
		$writer = new FileWriter();
		$writer->write($this->folder . DIRECTORY_SEPARATOR . $this->file, $this->content);

		$this->assertEquals(file_get_contents($this->folder . DIRECTORY_SEPARATOR . $this->file), $this->content);
		
	}

	public function testUnableToWrite()
	{
		chmod($this->folder, 0000);

		$this->expectException(UnableToWriteFileException::class);
		$writer = new FileWriter();
		$writer->write($this->folder . DIRECTORY_SEPARATOR . $this->file, $this->content);
		#unlink($this->folder . DIRECTORY_SEPARATOR . $this->file);
		#rmdir($this->folder);
	}

	public function tearDown()
	{
		chmod($this->folder, 0700);
		if (file_exists($this->folder . DIRECTORY_SEPARATOR . $this->file)) {
			unlink($this->folder . DIRECTORY_SEPARATOR . $this->file);
		}
		rmdir($this->folder);
	}
}