<?php 

use Language\Application\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
	public function setUp()
	{
		$this->config = new Config();
	}

	public function testGeneralTestReturn()
	{
		$return = $this->config->get('system.paths.root');
	
		$this->assertInternalType('string', $return);
		$this->assertTrue(is_dir($return));

		$return = $this->config->get('system.translated_applications');
		$this->assertInternalType('array', $return);

		$return = $this->config->get('');
		$this->assertTrue(empty($return));
	}
}