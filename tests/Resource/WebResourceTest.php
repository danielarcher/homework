<?php 

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Resource\WebResource;
use PHPUnit\Framework\TestCase;

class WebResourceTest extends TestCase
{
	public function testConstruct()
	{
		$config = $this->createMock(Config::class);
		$api = $this->createMock(Api::class);
		$webResource = new WebResource($config, $api);

		$this->assertInstanceOf(Config::class, $webResource->getConfig());
		$this->assertInstanceOf(Api::class, $webResource->getApi());
	}

	public function testGetLanguagesSuccess()
	{
		$api = $this->createMock(Api::class);
		
		$config = $this->getMockBuilder(Config::class)
                       ->getMock();
	    $config->expects($this->exactly(1))
               ->method('get')
               ->will($this->returnValue(['testApplication'=>['en','br']]));
		
		$webResource = new WebResource($config, $api);
		$this->assertEquals(['en','br'], $webResource->getLanguages('testApplication'));
	}
}