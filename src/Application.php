<?php 

namespace Language;

class Application extends GenericApplication
{
	protected function getLanguages()
	{
		$applications = Config::get('system.translated_applications');
		return $applications[$this->getId()];
	}

	protected function getLanguageFile($language)
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
			throw new \Exception('Error during getting language file: (' . $this->getId() . '/' . $language . ')');
		}

		return $languageResponse['data'];
	}

	protected function generateFile($content, $language)
	{
		$destination = $this->getLanguageCachePath($language);

		return FileHandle::save($destination, $content);
	}

	protected function getLanguageCachePath($language)
	{
		return Config::get('system.paths.root') . '/cache/' . $this->getId(). '/' . $language . '.php';
	}
}