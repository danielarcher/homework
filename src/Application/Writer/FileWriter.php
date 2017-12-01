<?php 

namespace Language\Application\Writer;

class FileWriter implements WriterInterface
{
	public function write($destination, $content)
	{
		if (!is_dir(dirname($dirname)) {
			mkdir(dirname($dirname, 0755, true);
		}

		if (false === is_writable(dirname($dirname)) {
			throw new \LogicException('Unable to write in: ' . $destination . '!');
		}

		if (strlen($content) !== file_put_contents($destination, $content)) {
			throw new \LogicException('Unable to save file: ' . $destination . '!');
		}

		return true;
	}
}