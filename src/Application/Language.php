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
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return string
     */
    public function getCacheFile()
    {
        return $this->cacheFile;
    }

}