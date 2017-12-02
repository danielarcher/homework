<?php 

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\LanguageCollection;
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
		$app = 'testApplication';
		$this->config->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue([$app => ['fr-lu', 'de-lu', 'lu']]));
		

		$webResource = new WebResource($this->config, $this->api);
		$this->assertInstanceOf(LanguageCollection::class, $webResource->getLanguages($app));
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

	public function testGetLanguageFile()
	{
		$this->api->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue('language data'));

		$webResource = new WebResource($this->config, $this->api);
		$this->assertEquals('language data', $webResource->getLanguageFile('', ''));
	}
}