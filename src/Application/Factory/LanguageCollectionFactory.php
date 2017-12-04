<?php 

namespace Language\Application\Factory;

use Language\Application\Factory\LanguageFactory;
use Language\Application\Language;
use Language\Application\LanguageCollection;
use Language\Application\Resource\ResourceInterface;
use Language\Application\Writer\WriterInterface;

class LanguageCollectionFactory
{
    protected $resource;
    
    /**
     * Create new Translation class
     * @param string            $app      applications id
     * @param ResourceInterface $resource resource to get correct data
     * @param WriterInterface   $writer   manager to save collected data
     */
    public function __construct(ResourceInterface $resource, LanguageFactory $languageFactory)
    {
        $this->resource = $resource;
        $this->languageFactory = $languageFactory;
    }

    /**
     * create object collection
     * @return LanguageCollection
     */
    public function create($applicationId)
    {
        $collection = new LanguageCollection();

        $languagesResource = $this->resource->getLanguages($applicationId);
        
        if (true === empty($languagesResource)) {
            return $collection;
        }

        foreach ($languagesResource as $languageId) {
            $collection->add($this->createLanguage($applicationId, $languageId));
        }

        return $collection;
    }

    /**
     * create new languages, based on params
     * @param  string $languageId
     * @return Language
     */
    public function createLanguage(string $appId, string $languageId)
    {
        return $this->languageFactory->create($appId, $languageId);
    }

    /**
     * @return ResourceInterface
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return LanguageFactory
     */
    public function getLanguageFactory()
    {
        return $this->languageFactory;
    }
}
