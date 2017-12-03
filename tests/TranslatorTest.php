<?php 

use Language\Application\Language;
use Language\Application\LanguageCollection;
use Language\Application\Translator;
use Language\Application\Writer\WriterInterface;
use PHPUnit\Framework\TestCase;

class TranslatorTest extends TestCase
{
	public function setUp()
	{
		$this->writer = $this->getMockBuilder(WriterInterface::class)->getMock();
		$this->languageCollection = $this->getMockBuilder(LanguageCollection::class)->disableOriginalConstructor()->getMock();
		$this->language = $this->getMockBuilder(Language::class)->disableOriginalConstructor()->getMock();
	}

	public function testConstruct()
	{
		$translator = new Translator('appId', $this->languageCollection, $this->writer);

		$this->assertEquals('appId', $translator->getApp());
	}

	public function testEmptyLanguages()
	{
		$this->languageCollection->expects($this->any())
			->method('getIterator')
			->will($this->returnValue(new \ArrayIterator()));

		$translator = new Translator('appId', $this->languageCollection, $this->writer);
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

		$this->languageCollection->expects($this->any())
			->method('getIterator')
			->will($this->returnValue(new \ArrayIterator([$this->language, $this->language])));

		$this->languageCollection->expects($this->any())
			->method('count')
			->will($this->returnValue(2));

		$translator = new Translator('appId', $this->languageCollection, $this->writer);
		$translator->run();
	}
}