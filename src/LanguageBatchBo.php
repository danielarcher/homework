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
		foreach ($applications as $applicationId) {
			try {
				$filesGenerator = new FilesGenerator(new WebApplication($applicationId));
				$filesGenerator->setLogger($logger);
				$filesGenerator->composeFiles();
			} catch (\Exception $e) {
				$logger->error($e->getMessage());
			}
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
		$logger->debug("Getting applet language XMLs..");

		foreach ($applets as $appletLanguageId) {
			try {
				$filesGenerator = new FilesGenerator(new AppletApplication($appletLanguageId));
				$filesGenerator->setLogger($logger);
				$filesGenerator->composeFiles();
			} catch (\Exception $e) {
				$logger->error($e->getMessage());
			}
		}

		$logger->debug("Applet language XMLs generated.");
	}

	protected static function getLogger()
	{
		$log = new Logger('LanguageBathBo');
		$log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
		return $log;
	}
}
