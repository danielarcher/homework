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

	public function testGetApplicationsSuccess()
	{
		$apps = ['testApplication'];
		$this->config->expects($this->any())
			->method('get')
			->will($this->returnValue(['testApplication' => 'lang']));
		

		$webResource = new WebResource($this->config, $this->api);
		$this->assertInternalType('array', $webResource->getApplications());
		$this->assertEquals($apps, $webResource->getApplications());
	}

	public function testGetLanguagesSuccess()
	{
		$languages = ['fr-lu', 'de-lu', 'lu'];
		$app = 'testApplication';
		$this->config->expects($this->exactly(2))
			->method('get')
			->will($this->returnValue([$app => $languages]));
		

		$webResource = new WebResource($this->config, $this->api);
		$this->assertInternalType('array', $webResource->getLanguages($app));
		$this->assertEquals($languages, $webResource->getLanguages($app));
	}

	public function testGetLanguagesEmpty()
	{
		$app = 'testApplication';
		$this->config->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue([$app => null]));
		

		$webResource = new WebResource($this->config, $this->api);
		$this->assertEquals(null, $webResource->getLanguages($app));
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