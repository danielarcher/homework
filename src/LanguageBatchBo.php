<?php

namespace Language;

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Factory\LanguageCollectionFactory;
use Language\Application\Factory\LanguageFactory;
use Language\Application\Resource\AppletResource;
use Language\Application\Resource\ResourceInterface;
use Language\Application\Resource\WebResource;
use Language\Application\Translator;
use Language\Application\Writer\FileWriter;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Psr\Log\LoggerInterface;

/**
 * Business logic related to generating language files.
 */
class LanguageBatchBo
{
	public function __construct()
	{
		$this->logger = $this->getLogger();
	}

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
			$this->translateApplication($applications, $resource, $this->logger);
		} catch (\Exception $e) {
			$this->logger->error($e->getMessage());
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
			$this->translateApplication($applications, $resource, $this->logger);
		} catch (\Exception $e) {
			$this->logger->error($e->getMessage());
		}
	}

	public function translateApplication(array $applications, ResourceInterface $resource, LoggerInterface $logger)
	{
		$logger->debug('Received ' .count($applications) . ' apps to translate');
		
		$factory = new LanguageCollectionFactory($resource, new LanguageFactory($resource));

		foreach ($applications as $applicationId) {
			$logger->debug(sprintf("--Generating translation for [%s]", $applicationId));
			
			$collection = $factory->create($applicationId);

			$logger->debug(sprintf("----Found %d languages: %s", count($collection), json_encode($collection->getLanguagesNames())));
			
			$translator = new Translator($applicationId, $collection, new FileWriter());
			$translator->run();
		}
	}

	/**
	 * Create a new logger
	 * @return Monolog\Logger
	 */
	public function getLogger()
	{
		$output = "[%datetime%] pid:%extra.process_id% memory:%extra.memory_usage% %channel%.%level_name%: %message%\n";
		$formatter = new LineFormatter($output);

		$streamHandler = new StreamHandler('php://stdout', Logger::DEBUG);
		$streamHandler->setFormatter($formatter);

		$errorHandler = new StreamHandler(__DIR__ . '/../logs/error.log', Logger::ERROR);
		$errorHandler->setFormatter($formatter);

		$logger = new Logger('LanguageBatchBo');
		$logger->pushProcessor(new ProcessIdProcessor());
		$logger->pushProcessor(new MemoryUsageProcessor());
		$logger->pushHandler($streamHandler);
		$logger->pushHandler($errorHandler);
		return $logger;
	}
}
