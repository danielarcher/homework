<?php 

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Resource\AppletResource;
use PHPUnit\Framework\TestCase;

class AppletResourceTest extends TestCase
{
	public function setUp()
	{
		$this->config = $this->getMockBuilder(Config::class)->getMock();
		$this->api    = $this->getMockBuilder(Api::class)->getMock();
	}

	public function testConstruct()
	{
		$appletResource = new AppletResource($this->config, $this->api);

		$this->assertInstanceOf(Config::class, $appletResource->getConfig());
		$this->assertInstanceOf(Api::class, $appletResource->getApi());
	}

	public function testGetLanguagesSuccess()
	{
		$this->api->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue(['fr-lu', 'de-lu', 'lu']));

		$appletResource = new AppletResource($this->config, $this->api);
		$this->assertEquals(['fr-lu', 'de-lu', 'lu'], $appletResource->getLanguages(''));
	}

	public function testGetLanguageFile()
	{
		$this->api->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue('language data'));

		$appletResource = new AppletResource($this->config, $this->api);
		$this->assertEquals('language data', $appletResource->getLanguageFile('', ''));
	}
}