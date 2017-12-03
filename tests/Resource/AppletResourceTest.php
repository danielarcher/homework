<?php 

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\LanguageCollection;
use Language\Application\Resource\AppletResource;
use PHPUnit\Framework\TestCase;

class AppletResourceTest extends TestCase
{
	public function setUp()
	{
		$this->config = $this->getMockBuilder(Config::class)->getMock();
		$this->api    = $this->getMockBuilder(Api::class)->getMock();
		$this->collection = $this->getMockBuilder(LanguageCollection::class)->getMock();
	}

	public function testConstruct()
	{
		$appletResource = new AppletResource($this->config, $this->api);

		$this->assertInstanceOf(Config::class, $appletResource->getConfig());
		$this->assertInstanceOf(Api::class, $appletResource->getApi());
	}

	public function testGetLanguagesSuccess()
	{
		$languages = ['fr-lu', 'de-lu', 'lu'];
		$this->api->expects($this->exactly(2))
			->method('get')
			->will($this->returnValue($languages));

		$appletResource = new AppletResource($this->config, $this->api);
		$this->assertInternalType('array', $appletResource->getLanguages('myApp'));
		$this->assertEquals($languages, $appletResource->getLanguages('myApp'));
	}

	public function testGetLanguageFile()
	{
		$this->api->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue('language data'));

		$appletResource = new AppletResource($this->config, $this->api);
		$this->assertEquals('language data', $appletResource->getLanguageFile('', ''));
	}

	public function testReturnCachePath()
	{
		$this->config->expects($this->exactly(1))
			->method('get')
			->with('system.paths.root')
			->will($this->returnValue('test'));

		$appletResource = new AppletResource($this->config, $this->api);
		$path = $appletResource->getLanguageCachePath('app', 'en');

		$this->assertEquals('test/cache/flash/lang_en.xml', $path);
	}
}