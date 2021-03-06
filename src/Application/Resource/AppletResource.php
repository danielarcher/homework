<?php 

namespace Language\Application\Resource;

use Language\Application\Api;
use Language\Application\Config;
use Language\Application\Resource\ResourceInterface;

class AppletResource implements ResourceInterface
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
     * @codeCoverageIgnore
     * @return array
     */
    public function getApplications()
    {
        return array(
            'memberapplet' => 'JSM2_MemberApplet',
        );
    }

    /**
     * get the languages for application
     * @param  string $appId
     * @return array
     */
    public function getLanguages(string $appId) : array
    {
        return $this->api->get(
            'system_api',
            'language_api',
            array(
                'system' => 'LanguageFiles',
                'action' => 'getAppletLanguages'
            ),
            array('applet' => $appId)
        );
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
                'action' => 'getAppletLanguageFile'
            ),
            array(
                'applet' => $appId,
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
        return $this->config->get('system.paths.root') . '/cache/flash/lang_' . $language . '.xml';
    }
}
