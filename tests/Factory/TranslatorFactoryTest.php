<?php 

use Language\Application\Factory\TranslatorFactory;
use Language\Application\Language;
use Language\Application\Resource\ResourceInterface;
use Language\Application\Translator;
use Language\Application\Writer\WriterInterface;
use PHPUnit\Framework\TestCase;

class TranslatorFactoryTest extends TestCase
{
    public function setUp()
    {
        $this->resource = $this->getMockBuilder(ResourceInterface::class)->getMock();
        $this->writer = $this->getMockBuilder(WriterInterface::class)->getMock();
        $this->language = $this->getMockBuilder(Language::class)->disableOriginalConstructor()->getMock();
    }

    public function testConstruct()
    {
        $factory = new TranslatorFactory('app', $this->resource, $this->writer);
        
        $this->assertInstanceOf(ResourceInterface::class, $factory->getResource());
        $this->assertInstanceOf(WriterInterface::class, $factory->getWriter());
    }

    public function testCreateMethodReturnTranslator()
    {
        $factory = new TranslatorFactory('app', $this->resource, $this->writer);
        $this->assertInstanceOf(Translator::class, $factory->create());
    }
}