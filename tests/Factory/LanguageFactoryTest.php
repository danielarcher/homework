<?php 

use Language\Application\Exception\LanguageCacheFileNullException;
use Language\Application\Exception\LanguageFileNotFoundException;
use Language\Application\Factory\LanguageFactory;
use Language\Application\Language;
use Language\Application\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

class LanguageFactoryTest extends TestCase
{
    public function setUp()
    {
        $this->resource = $this->getMockBuilder(ResourceInterface::class)
                               ->getMock();
    }

    public function testCreateLanguage()
    {
        $this->resource->expects($this->exactly(1))
            ->method('getLanguageFile')
            ->will($this->returnValue("languageContent"));
        
        $this->resource->expects($this->exactly(1))
            ->method('getLanguageCachePath')
            ->will($this->returnValue("language.txt"));
        
        $language = (new LanguageFactory('a', 'b', $this->resource))->create();
        
        $this->assertInstanceOf(Language::class, $language);
        $this->assertEquals("languageContent", $language->getContent());
        $this->assertEquals("language.txt", $language->getCacheFile());
    }

    public function testFileNotFound()
    {
        $this->expectException(LanguageFileNotFoundException::class);
        $language = (new LanguageFactory('a', 'b', $this->resource))->create();
    }

    public function testCacheFileNull()
    {
        $this->resource->expects($this->exactly(1))
            ->method('getLanguageFile')
            ->will($this->returnValue("languageContent"));
        
        $this->expectException(LanguageCacheFileNullException::class);
        $language = (new LanguageFactory('a', 'b', $this->resource))->create();
    }
}
