<?php 

namespace Language\Application\Writer;

class FileWriter implements WriterInterface
{
	public function write($destination, $content)
	{
		$this->prepareDirectory(dirname($destination));

		if (strlen($content) !== file_put_contents($destination, $content)) {
			throw new \LogicException('Unable to save file: ' . $destination . '!');
		}

		return true;
	}

	private function prepareDirectory($dirname)
	{
		if (!is_dir($dirname)) {
			mkdir($dirname, 0755, true);
		}

		if (false === is_writable($dirname)) {
			throw new \LogicException('Unable to write in: ' . $destination . '!');
		}
	}
}