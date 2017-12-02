<?php 

namespace Language\Application\Writer;

class FileWriter implements WriterInterface
{
	public function write($file, $content)
	{

		if (false === is_dir(dirname($file))) {
			mkdir(dirname($file), 0755, true);
		}

		if (false === is_writable(dirname($file))) {
			throw new \LogicException('Unable to write in: ' . $file . '!');
		}

		if (strlen($content) !== file_put_contents($file, $content)) {
			throw new \LogicException('Unable to save file: ' . $file . '!');
		}

		return true;
	}
}