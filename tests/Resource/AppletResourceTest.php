<?php 

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Resource\AppletResource;
use PHPUnit\Framework\TestCase;

class AppletResourceTest extends TestCase
{
	public function testConstruct()
	{
		$config = $this->createMock(Config::class);
		$api = $this->createMock(Api::class);
		$appletResource = new AppletResource($config, $api);

		$this->assertInstanceOf(Config::class, $appletResource->getConfig());
		$this->assertInstanceOf(Api::class, $appletResource->getApi());
	}

	public function testGetLanguagesSuccess()
	{
		$config = $this->createMock(Config::class);
		$api = $this->getMockBuilder(Api::class)
					->getMock();
	    $api->expects($this->exactly(1))
			->method('get')
			->will($this->returnValue(['en', 'br']));
		

		$appletResource = new AppletResource($config, $api);
		$this->assertEquals(['en','br'], $appletResource->getLanguages(''));
	}
}