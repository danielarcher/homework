<?php

namespace Language;

use Language\Application\AppletApplication;
use Language\Application\WebApplication;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
	/**
	 * Contains the applications which ones require translations.
	 *
	 * @var array
	 */
	protected static $applications = array();

	/**
	 * Starts the language file generation.
	 *
	 * @return void
	 */
	public static function generateLanguageFiles()
	{
		// The applications where we need to translate.
		self::$applications = Config::get('system.translated_applications');
		$logger = self::getLogger();
		$logger->debug("Generating language files");
		
		foreach (self::$applications as $applicationId => $languages) {
			$languageApplication = new WebApplication($applicationId);
			$languageApplication->setLogger($logger);
			$languageApplication->composeFiles();
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
			$applet = new AppletApplication($appletLanguageId);
			$applet->setLogger($logger);
			$applet->composeFiles();
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
