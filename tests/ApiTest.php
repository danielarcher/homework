<?php 

use Language\Application\Api;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
	public function testGetSuccess()
	{
		$api = new Api();
		$return = $api->get('','',array('action'=>'getAppletLanguages'),array());
		$this->assertEquals(array('en'), $return);
	}

	public function testEmptyReturn()
	{
		$api = new Api();
		$this->expectException(InvalidArgumentException::class);
		$api->get('','',array(),array());
	}

	public function testInvalidStatus()
	{
		$api = new Api();
		$this->expectException(LogicException::class);
		$api->isValidResult(['status'=>'error']);
	}

	public function testNullReturn()
	{
		$api = new Api();
		$this->expectException(LogicException::class);
		$api->isValidResult(null);
	}
}