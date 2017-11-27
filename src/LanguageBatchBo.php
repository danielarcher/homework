<?php

namespace Language;

use Language\Application\AppletApplication;
use Language\Application\FilesGenerator;
use Language\Application\WebApplication;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
	/**
	 * Starts the language file generation.
	 *
	 * @return void
	 */
	public static function generateLanguageFiles()
	{
		$logger = self::getLogger();
		$logger->debug("Generating language files");

		$applications = array_keys(Config::get('system.translated_applications'));

		try {
			self::generate($applications, WebApplication::class);
		} catch (\Exception $e) {
			$logger->error($e->getMessage());
		}
	}

	/**
	 * Gets the language files for the applet and puts them into the cache.
	 *
	 * @throws Exception   If there was an error.
	 *
	 * @return void
	 */
	public static function generateAppletLanguageXmlFiles()
	{
		// List of the applets [directory => applet_id].
		$applets = array(
			'memberapplet' => 'JSM2_MemberApplet',
		);
		$logger = self::getLogger();
		$logger->debug("Generating applet language XMLs..");

		try {
			self::generate($applets, AppletApplication::class);
		} catch (\Exception $e) {
			$logger->error($e->getMessage());
		}
	}

	/**
	 * Create a new logger
	 * @return Monolog\Logger
	 */
	protected static function getLogger()
	{
		$log = new Logger('LanguageBathBo');
		$log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
		return $log;
	}

	/**
	 * Call the compose files method for the refered applications
	 * @param  array  $applications Applications
	 * @param  string $appClass     Translatable class of application type
	 * @return void
	 */
	protected static function generate(array $applications, string $appClass)
	{
		if (false === class_exists($appClass)) {
			throw new \InvalidArgumentException("Application class [{$appClass}] do not exists");
		}

		foreach ($applications as $appId) {
			try {
				$filesGenerator = new FilesGenerator( new $appClass($appId));
				$filesGenerator->setLogger(self::getLogger());
				$filesGenerator->composeFiles();
			} catch (\Exception $e) {
				throw new \DomainException("Error composing translation files: ". $e->getMessage(), 1);
			}
		}
	}
}
