<?php 

namespace Language\Application;

use Language\ApiCall;
use Language\Application\Application;
use Language\Application\Translator\TranslatableInterface;
use Language\Config;
use Language\Handler\ApiErrorHandler;

class WebApplication extends Application implements TranslatableInterface
{
	/**
	 * return the necessary languages to translate
	 * @return array
	 */
	public function getLanguages()
	{
		$applications = Config::get('system.translated_applications');
		return $applications[$this->getId()];
	}

	/**
	 * return the languageFile to be created
	 * @param  string $language 
	 * @return string
	 */
	public function getLanguageFile(string $language)
	{
		return $this->languageDiscover->getFile($language);
	}

	/**
	 * return the path for the language cache
	 * @param  string $language
	 * @return string
	 */
	public function getLanguageCachePath(string $language)
	{
		return Config::get('system.paths.root') . '/cache/' . $this->getId(). '/' . $language . '.php';
	}
}