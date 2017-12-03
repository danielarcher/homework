<?php 

use Language\Application\Language;
use Language\Application\LanguageCollection;
use Language\Application\Translator;
use Language\Application\Writer\WriterInterface;
use PHPUnit\Framework\TestCase;

class LanguageCollectionTest extends TestCase
{
	public function setUp()
	{
		$this->language = $this->getMockBuilder(Language::class)->disableOriginalConstructor()->getMock();
	}

	public function testAddMany()
	{
		$collection = new LanguageCollection();
		$collection->addMany([$this->language, $this->language]);
		$collection->addMany([$this->language, $this->language]);

		$this->assertEquals(4, count($collection));
	}
}