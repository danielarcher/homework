<?php

namespace Language;

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Resource\WebResource;
use Language\Application\Resource\AppletResource;
use Language\Application\Translator\TranslationGenerator;
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

		$config = new Config();
		$resource = new WebResource($config, new Api());
		
		$applications = $this->getWebApplications($config);
		
		try {
			foreach ($applications as $app) {
				$logger->debug("--Application " . $app);
				$translator = new TranslationGenerator($app, $resource, new FileWriter());
				$translator->composeFiles();
			}
		} catch (\Exception $e) {
			$logger->error($e->getMessage());
		}
	}

	public function getWebApplications(Config $config)
	{
		$apps = $config->get('system.translated_applications');
		return array_keys($apps);
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
		
		$logger = $this->getLogger();
		$logger->debug("Generating language files");

		$config = new Config();
		$resource = new AppletResource($config, new Api());

		$applications = array(
			'memberapplet' => 'JSM2_MemberApplet',
		);
		
		try {
			foreach ($applications as $app) {
				$translator = new TranslationGenerator($app, $resource, new FileWriter());
				$translator->composeFiles();
			}
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

		$logger = $this->getLogger();

		foreach ($applications as $appId) {
			try {
				$languageDiscover = new LanguageDiscover();
				$app = new $appClass($appId, $languageDiscover);
				$logger->debug('--Application: ' . $app->getId());

				$translator = new TranslationGenerator($app, new FileWriter());
				$translator->composeFiles();
			} catch (\Exception $e) {
				throw new \DomainException("Error composing translation files: ". $e->getMessage(), 1);
			}
		}
	}
}
