<?php 

use Language\Application\Language;
use Language\Application\Translator;
use Language\Application\Writer\WriterInterface;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{
	public function setUp()
	{
		$this->writer = $this->getMockBuilder(WriterInterface::class)->getMock();
		$this->language = $this->getMockBuilder(Language::class)->disableOriginalConstructor()->getMock();
	}

	public function testConstruct()
	{
		$translator = new Translator('appId', $this->writer);

		$this->assertEquals('appId', $translator->getApp());
	}

	public function testEmptyLanguages()
	{
		$translator = new Translator('appId', $this->writer);
		$this->assertEquals(false, $translator->run());
	}

	public function testWriteLoop()
	{
		$this->writer->expects($this->exactly(2))
			->method('write')
			->with('cacheFile.txt', 'content data')
			->will($this->returnValue(true));

		$this->language->expects($this->exactly(2))
			->method('getCacheFile')
			->will($this->returnValue('cacheFile.txt'));

		$this->language->expects($this->exactly(2))
			->method('getContent')
			->will($this->returnValue('content data'));



		$translator = new Translator('appId', $this->writer);
		$translator->addLanguage($this->language);
		$translator->addLanguage($this->language);
		$translator->run();
	}
}