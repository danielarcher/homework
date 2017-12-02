<?php 

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Resource\WebResource;
use PHPUnit\Framework\TestCase;

class WebResourceTest extends TestCase
{
	public function setUp()
	{
		$this->config = $this->getMockBuilder(Config::class)->getMock();
		$this->api    = $this->getMockBuilder(Api::class)->getMock();
	}

	public function testConstruct()
	{
		$webResource = new WebResource($this->config, $this->api);

		$this->assertInstanceOf(Config::class, $webResource->getConfig());
		$this->assertInstanceOf(Api::class, $webResource->getApi());
	}

	public function testGetLanguagesSuccess()
	{
		$this->config->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue(['testApplication' => ['fr-lu', 'de-lu', 'lu']]));
		

		$webResource = new WebResource($this->config, $this->api);
		$this->assertEquals(['fr-lu', 'de-lu', 'lu'], $webResource->getLanguages('testApplication'));
	}

	public function testReturnCachePath()
	{
		$this->config->expects($this->exactly(1))
			->method('get')
			->with('system.paths.root')
			->will($this->returnValue('test'));

		$webResource = new WebResource($this->config, $this->api);
		$path = $webResource->getLanguageCachePath('app', 'en');

		$this->assertEquals('test/cache/app/en.php', $path);
	}
}