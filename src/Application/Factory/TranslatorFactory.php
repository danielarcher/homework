<?php 

namespace Language\Application\Factory;

use Language\Application\Factory\LanguageFactory;
use Language\Application\Resource\ResourceInterface;
use Language\Application\Translator;
use Language\Application\Language;
use Language\Application\Writer\WriterInterface;

class TranslatorFactory
{
	protected $app;

	protected $resource;

	protected $writer;

	/**
	 * Create new Translation class
	 * @param string            $app      applications id
	 * @param ResourceInterface $resource resource to get correct data
	 * @param WriterInterface   $writer   manager to save collected data
	 */
	public function __construct(string $app, ResourceInterface $resource, WriterInterface $writer)
	{
		$this->app = $app;
		$this->resource = $resource;
		$this->writer = $writer;
	}

	/**
	 * create object translator
	 * @return Translator
	 */
	public function create()
	{
		$translator = new Translator($this->app, $this->writer);

		$languagesResource = $this->resource->getLanguages($this->app);
		
		if (true === empty($languagesResource)) {
			return $translator;
		}

		foreach ($languagesResource as $languageId) {
			$translator->addLanguage($this->createLanguage($languageId));
		}

		return $translator;
	}

	/**
	 * create new languages, based on params 
	 * @param  string $languageId 
	 * @return Language
	 */
	public function createLanguage(string $languageId)
	{
		return (new LanguageFactory($this->app, $languageId, $this->resource))->create();
	}

    /**
     * @return ResourceInterface
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @return WriterInterface
     */
    public function getWriter()
    {
        return $this->writer;
    }

}