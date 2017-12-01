<?php 

use Language\Application\Writer\FileWriter;
use PHPUnit\Framework\TestCase;

class FileWriterTest extends TestCase
{
	/**
	 * @dataProvider filesProvider
	 */
	public function testWrite($file, $content)
	{
		$writer = new FileWriter();
		$writer->write($file, $content);

		$this->assertEquals(file_get_contents($file), $content);
	}

	public function filesProvider()
	{
		return [
			1 => array('testFolder/testFile.txt', 'my content')
		];
	}

	public function tearDown()
	{
		unlink('testFolder/testFile.txt');
		rmdir('testFolder');
	}
}