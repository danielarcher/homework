<?php 

namespace Language\Application;

class Language
{
	private $id;

	private $content;

	private $cacheFile;

    /**
     * @param string $id        
     * @param string $content   
     * @param string $cacheFile 
     */
	public function __construct(string $id, string $content, string $cacheFile)
	{
		$this->id = $id;
		$this->content = $content;
		$this->cacheFile = $cacheFile;
	}

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getCacheFile(): string
    {
        return $this->cacheFile;
    }

}