<?php 

namespace Language\Application\Resource;

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Resource\ResourceInterface;

class WebResource implements ResourceInterface
{
    /**
     * @param Config $config
     * @param Api    $api
     */
    public function __construct(Config $config, Api $api)
    {
        $this->config = $config;
        $this->api = $api;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return Api
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @return array
     */
    public function getApplications()
    {
        $apps = $this->config->get('system.translated_applications');
        return array_keys($apps);
    }

    /**
     * get languages for application
     * @param  string $appId
     * @return array
     */
    public function getLanguages(string $appId)
    {
        return $this->config->get('system.translated_applications')[$appId];
    }

    /**
     * return the language data
     * @param  string $appId
     * @param  string $language
     * @return string
     */
    public function getLanguageFile(string $appId, string $language)
    {
        return $this->api->get(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getLanguageFile'
            ),
            array(
                'language' => $language
            )
        );
    }

    /**
     * return the language cache path
     * @param  string $appId
     * @param  string $language
     * @return string
     */
    public function getLanguageCachePath(string $appId, string $language)
    {
        return $this->config->get('system.paths.root') . '/cache/' . $appId. '/' . $language . '.php';
    }
}
