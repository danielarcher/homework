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
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     *
     * @return self
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCacheFile()
    {
        return $this->cacheFile;
    }

    /**
     * @param mixed $cacheFile
     *
     * @return self
     */
    public function setCacheFile($cacheFile)
    {
        $this->cacheFile = $cacheFile;

        return $this;
    }
}