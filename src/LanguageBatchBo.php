<?php

namespace Language;

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

		echo "\nGenerating language files\n";
		foreach (self::$applications as $applicationId => $languages) {
			$languageApplication = new Application($applicationId);
			$languageApplication->composeFiles();
		}
	}

	/**
	 * Gets the language file for the given language and stores it.
	 *
	 * @param string $application   The name of the application.
	 * @param string $language      The identifier of the language.
	 *
	 * @throws CurlException   If there was an error during the download of the language file.
	 *
	 * @return bool   The success of the operation.
	 */
	protected static function getLanguageFile($application, $language)
	{
		$languageApplication = new Application($application);
		return $languageApplication->getLanguageFile($language);
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

		echo "\nGetting applet language XMLs..\n";

		foreach ($applets as $appletLanguageId) {
			self::generateAppletXmlFile($appletLanguageId);
		}

		echo "\nApplet language XMLs generated.\n";
	}

	protected static function generateAppletXmlFile($appletLanguageId)
	{
		$applet = new Applet($appletLanguageId);
		$applet->generateXmlFiles();
	}
}
