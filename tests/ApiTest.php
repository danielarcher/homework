<?php 

use Language\Application\Api;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
	public function setUp()
	{
		$this->api = new Api();
	}

	public function testGetSuccess()
	{
		$return = $this->api->get('','',array('action'=>'getAppletLanguages'),array());
		$this->assertInternalType('array', $return);

		$return = $this->api->get('','',array('action'=>'getLanguageFile'),array());
		$this->assertInternalType('string', $return);

		$return = $this->api->get('','',array('action'=>'getAppletLanguageFile'),array());
		$this->assertInternalType('string', $return);

		$this->expectException(InvalidArgumentException::class);
		$return = $this->api->get('','',array('action'=>'notFound'),array());
	}

	public function testEmptyAction()
	{
		$this->expectException(InvalidArgumentException::class);
		$return = $this->api->get('','',array('action'=>null),array());
	}

	public function testEmptyReturn()
	{
		$this->expectException(InvalidArgumentException::class);
		$this->api->validateResult(array());
	}

	public function testEmptyDataReturn()
	{
		$this->expectException(InvalidArgumentException::class);
		$this->api->validateResult(array('status'=>'OK', 'data'=>null));
	}

	public function testInvalidStatus()
	{
		$this->expectException(LogicException::class);
		$this->api->validateResult(['status'=>'error']);
	}

	public function testNullReturn()
	{
		$this->expectException(LogicException::class);
		$this->api->validateResult(null);
	}
}