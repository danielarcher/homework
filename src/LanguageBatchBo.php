<?php

namespace Language;

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Factory\TranslatorFactory;
use Language\Application\Generator\TranslationGenerator;
use Language\Application\Resource\AppletResource;
use Language\Application\Resource\ResourceInterface;
use Language\Application\Resource\WebResource;
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

		$resource = new WebResource(new Config(), new Api());

		$applications = $this->getWebApplications(new Config());

		try {
			$this->translateApplication($applications, $resource, $logger);
		} catch (\Exception $e) {
			$logger->error($e->getMessage());
		}
	}

	public function getWebApplications(Config $config)
	{
		$apps = $config->get('system.translated_applications');
		return array_keys($apps);
	}

	public function getAppletApplications()
	{
		return array(
			'memberapplet' => 'JSM2_MemberApplet',
		);
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
		$logger->debug("Generating applet language files");

		$resource = new AppletResource(new Config(), new Api());

		$applications = $this->getAppletApplications();
		
		try {
			$this->translateApplication($applications, $resource, $logger);
		} catch (\Exception $e) {
			$logger->error($e->getMessage());
		}
	}

	public function translateApplication(array $applications, ResourceInterface $resource, $logger)
	{
		
		foreach ($applications as $app) {
			$logger->debug("--Applet " . $app);
			$factory = new TranslatorFactory($app, $resource, new FileWriter());
			$translator = $factory->create();
			$translator->run();
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
}
