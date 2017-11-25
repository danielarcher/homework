<?php 

namespace Language;

class Applet
{
	private $appletId;

	public function __construct($appletId)
	{
		$this->setAppletId($appletId);
	}

	public function setAppletId($id)
	{
		$this->appletId = $id;
	}

	public function getAppletId()
	{
		return $this->appletId;
	}

	public function getLanguages()
	{
		$result = ApiCall::call(
			'system_api',
			'language_api',
			array(
				'system' => 'LanguageFiles',
				'action' => 'getAppletLanguages'
			),
			array('applet' => $this->getAppletId())
		);

		try {
			ApiCallErrorVerifier::checkError($result);
		}
		catch (\Exception $e) {
			throw new \Exception('Getting languages for applet (' . $applet . ') was unsuccessful ' . $e->getMessage());
		}

		return $result['data'];
	}
}