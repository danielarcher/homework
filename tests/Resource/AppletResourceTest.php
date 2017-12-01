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
}