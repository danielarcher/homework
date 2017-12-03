<?php 

namespace Language\Application\Writer;

use Language\Application\Exception\UnableToWriteFileException;
use Language\Application\Writer\WriterInterface;

class FileWriter implements WriterInterface
{
	public function write(string $file, string $content)
	{
		if (false === is_dir(dirname($file))) {
			mkdir(dirname($file), 0755, true);
		}

		if (false === is_writable(dirname($file))) {
			throw new UnableToWriteFileException('Unable to write in: ' . $file . '!');
		}

		return file_put_contents($file, $content);
	}
}