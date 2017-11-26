<?php 

use Language\Application\WebApplication;
use PHPUnit\Framework\TestCase;

class WebApplicationTest extends TestCase
{
	public function testGetLanguageReturnArray()
	{
		$webApplication = new WebApplication('portal');
		$this->assertInternalType('array', $webApplication->getLanguages());
	}

	public function testGetLanguageFileReturnString()
	{
		$webApplication = new WebApplication('portal');
		$this->assertInternalType('string', $webApplication->getLanguageFile('en'));
	}

	public function testGetLanguageCachePathReturnString()
	{
		$webApplication = new WebApplication('portal');
		$this->assertInternalType('string', $webApplication->getLanguageCachePath('en'));
	}

}