<?php 

namespace Language;

class FileHandle
{
	public static function save($destination, $content)
	{
		if (!is_dir(dirname($destination))) {
			mkdir(dirname($destination), 0755, true);
		}

		if (strlen($content) !== file_put_contents($destination, $content)) {
			throw new \Exception('Unable to save file: ' . $destination . '!');
		}

		return true;
	}
}