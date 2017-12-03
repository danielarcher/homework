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
use Psr\Log\LoggerInterface;

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
		$resource = new WebResource(new Config(), new Api());
		$applications = $resource->getApplications();

		try {
			$this->translateApplication($applications, $resource, $this->getLogger());
		} catch (\Exception $e) {
			$this->getLogger()->error($e->getMessage());
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
		$resource = new AppletResource(new Config(), new Api());
		$applications = $resource->getApplications();
		
		try {
			$this->translateApplication($applications, $resource, $this->getLogger());
		} catch (\Exception $e) {
			$this->getLogger()->error($e->getMessage());
		}
	}

	public function translateApplication(array $applications, ResourceInterface $resource, LoggerInterface $logger)
	{
		$logger->debug('Received (' .count($applications) . ')apps for translation');
		foreach ($applications as $app) {
			$logger->debug(sprintf("Generating translation for app[%s]", $app));
			$factory = new TranslatorFactory($app, $resource, new FileWriter());
			$translator = $factory->create();
			$translator->run();
		}
	}

	/**
	 * Create a new logger
	 * @return Monolog\Logger
	 */
	public function getLogger()
	{
		$log = new Logger('LanguageBatchBo');
		$log->pushHandler(new StreamHandler('php://stdout', Logger::DEBUG));
		return $log;
	}
}
