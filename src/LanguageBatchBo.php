<?php

namespace Language;

use Language\Application\AppletApplication;
use Language\Application\Translator\TranslationGenerator;
use Language\Application\WebApplication;
use Language\Application\Writer\FileWriter;
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
	public function generateLanguageFiles()
	{
		$logger = $this->getLogger();
		$logger->debug("Generating language files");

		$applications = array_keys(Config::get('system.translated_applications'));
		$logger->debug(json_encode($applications));
		try {
			$this->generate($applications, WebApplication::class);
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
	public function generateAppletLanguageXmlFiles()
	{
		// List of the applets [directory => applet_id].
		$applets = array(
			'memberapplet' => 'JSM2_MemberApplet',
		);
		$logger = $this->getLogger();
		$logger->debug("Generating applet language XMLs..");
		$logger->debug(json_encode($applets));
		
		try {
			$this->generate($applets, AppletApplication::class);
		} catch (\Exception $e) {
			$logger->error($e->getMessage());
		}
	}

	/**
	 * Create a new logger
	 * @return Monolog\Logger
	 */
	protected function getLogger()
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
	protected function generate(array $applications, string $appClass)
	{
		if (false === class_exists($appClass)) {
			throw new \InvalidArgumentException("Application class [{$appClass}] do not exists");
		}

		foreach ($applications as $appId) {
			try {
				$translator = new TranslationGenerator( new $appClass($appId), new FileWriter(), $this->getLogger());
				$translator->composeFiles();
			} catch (\Exception $e) {
				throw new \DomainException("Error composing translation files: ". $e->getMessage(), 1);
			}
		}
	}
}
