<?php 

namespace Language\Application;

class Language
{
	private $id;

	private $content;

	private $cacheFile;

	public function __construct(string $id, string $content, string $cacheFile)
	{
		$this->id = $id;
		$this->content = $content;
		$this->cacheFile = $cacheFile;
	}

    /**
     * @codeCoverageIgnore
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @return mixed
     */
    public function getCacheFile()
    {
        return $this->cacheFile;
    }

}