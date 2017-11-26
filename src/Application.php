<?php 

namespace Language;

class Application
{
	private $applicationId;

	public function __construct($applicationId)
	{
		$this->setApplicationId($applicationId);
	}

	private function setApplicationId($applicationId)
	{
		$this->applicationId = $applicationId;
	}

	public function getApplicationId()
	{
		return $this->applicationId;
	}

	public function getLanguageFile($language)
	{
		$languageResponse = ApiCall::call(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getLanguageFile'
			),
			array('language' => $language)
		);

		try {
			ApiCallErrorVerifier::checkError($languageResponse);
		}
		catch (\Exception $e) {
			throw new \Exception('Error during getting language file: (' . $this->getApplicationId() . '/' . $language . ')');
		}

		return $this->generateFile($languageResponse, $language);
	}

	private function generateFile($languageApiResponse, $language)
	{
		$destination = $this->getLanguageCachePath($this->getApplicationId()) . $language . '.php';

		return FileHandle::save($destination, $languageApiResponse['data']);
	}

	public function getLanguageCachePath($language)
	{
		return Config::get('system.paths.root') . '/cache/' . $this->getApplicationId(). '/';
	}
}