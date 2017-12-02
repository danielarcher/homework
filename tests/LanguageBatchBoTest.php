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

		$this->resource->expects($this->exactly(1))
			->method('getLanguages')
			->will($this->returnValue(['lang1','lang2']));

		$this->resource->expects($this->exactly(2))
			->method('getLanguageFile')
			->will($this->returnValue($content));

		$this->resource->expects($this->exactly(2))
			->method('getLanguageCachePath')
			->will($this->returnValue($languageFile));

		$languageBatchBo = new LanguageBatchBo();
		$languageBatchBo->translateApplication($apps, $this->resource, $this->logger);

		$this->assertTrue(file_exists($languageFile));
		$this->assertEquals(file_get_contents($languageFile), $content);
		unlink($languageFile);
	}
}