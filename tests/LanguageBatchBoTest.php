<?php 

use Language\Application\Resource\ResourceInterface;
use Language\LanguageBatchBo;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class LanguageBatchBoTest extends TestCase
{
	public function setUp()
	{
		$this->resource = $this->getMockBuilder(ResourceInterface::class)
		    ->getMock();

		$this->logger = $this->getMockBuilder(LoggerInterface::class)
		    ->getMock();
	}

	public function testFunctionalTranslateApplication()
	{
		$apps = ['app'];
		$languageFile = 'testLanguage.xml';
		$content = 'content';
		$languages = ['lang1','lang2', 'lang3'];

		$this->resource->expects($this->exactly(1))
			->method('getLanguages')
			->will($this->returnValue($languages));

		$this->resource->expects($this->exactly(count($languages)))
			->method('getLanguageFile')
			->will($this->returnValue($content));

		$this->resource->expects($this->exactly(count($languages)))
			->method('getLanguageCachePath')
			->will($this->returnValue($languageFile));

		$languageBatchBo = new LanguageBatchBo();
		$languageBatchBo->translateApplication($apps, $this->resource, $this->logger);

		$this->assertTrue(file_exists($languageFile));
		$this->assertEquals(file_get_contents($languageFile), $content);
		unlink($languageFile);
	}

	public function testGetLoggerReturn()
	{
		$languageBatchBo = new LanguageBatchBo();
		$this->assertInstanceOf(LoggerInterface::class, $languageBatchBo->getLogger());
	}
}