<?php 

use Language\Application\Factory\LanguageCollectionFactory;
use Language\Application\Factory\LanguageFactory;
use Language\Application\Language;
use Language\Application\LanguageCollection;
use Language\Application\Resource\ResourceInterface;
use PHPUnit\Framework\TestCase;

class LanguageCollectionFactoryTest extends TestCase
{
    public function setUp()
    {
        $this->resource = $this->getMockBuilder(ResourceInterface::class)
            ->getMock();
        $this->languageFactory = $this->getMockBuilder(LanguageFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->language = $this->getMockBuilder(Language::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testConstruct()
    {
        $factory = new LanguageCollectionFactory($this->resource, $this->languageFactory);
        
        $this->assertInstanceOf(ResourceInterface::class, $factory->getResource());
        $this->assertInstanceOf(LanguageFactory::class, $factory->getLanguageFactory());
    }

    public function testCreateNewLanguage()
    {
        $appId = 'myApp';

        $this->languageFactory->expects($this->exactly(1))
            ->method('create')
            ->with($appId, 'fr')
            ->will($this->returnValue($this->language));

        $factory = new LanguageCollectionFactory($this->resource, $this->languageFactory);
        $newLanguage = $factory->createLanguage($appId, 'fr');

        $this->assertInstanceOf(Language::class, $newLanguage);
    }

    public function testCreateNewLanguageCollection()
    {
        $appId = 'myApp';
        $languages = ['fr','fr'];

        $this->resource->expects($this->exactly(1))
            ->method('getLanguages')
            ->will($this->returnValue($languages));

        $this->language->expects($this->exactly(2))
            ->method('getId')
            ->will($this->returnValue('fr'));

        $this->languageFactory->expects($this->exactly(2))
            ->method('create')
            ->with($appId, 'fr')
            ->will($this->returnValue($this->language));

        $factory = new LanguageCollectionFactory($this->resource, $this->languageFactory);
        $collection = $factory->create($appId);

        $this->assertInstanceOf(LanguageCollection::class, $collection);
        $this->assertEquals($languages, $collection->getLanguagesNames());
    }

    public function testCreateEmptyCollection()
    {
        $appId = 'myApp';
        $languages = null;

        $this->resource->expects($this->exactly(1))
            ->method('getLanguages')
            ->will($this->returnValue($languages));

        $factory = new LanguageCollectionFactory($this->resource, $this->languageFactory);
        $collection = $factory->create($appId);

        $this->assertInstanceOf(LanguageCollection::class, $collection);
        $this->assertTrue(empty($collection->getLanguagesNames()));
    }
}