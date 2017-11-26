<?php 

use Language\Application\AppletApplication;
use PHPUnit\Framework\TestCase;

class AppletApplicationTest extends TestCase
{
	public function testGetLanguageReturnArray()
	{
		$appletApplication = new AppletApplication('portal');
		$this->assertInternalType('array', $appletApplication->getLanguages());
	}

	public function testGetLanguageFileReturnString()
	{
		$appletApplication = new AppletApplication('portal');
		$this->assertInternalType('string', $appletApplication->getLanguageFile('en'));
	}

	public function testGetLanguageCachePathReturnString()
	{
		$appletApplication = new AppletApplication('portal');
		$this->assertInternalType('string', $appletApplication->getLanguageCachePath('en'));
	}

}