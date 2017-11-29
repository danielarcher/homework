<?php 

namespace Language\Handler;

class FileHandler
{
	public static function save($destination, $content)
	{
		if (!is_dir(dirname($destination))) {
			mkdir(dirname($destination), 0755, true);
		}

		if (false === is_writable(dirname($destination)))
		{
			throw new \LogicException('Unable to write in: ' . $destination . '!');
		}

		if (strlen($content) !== file_put_contents($destination, $content)) {
			throw new \LogicException('Unable to save file: ' . $destination . '!');
		}

		return true;
	}
}