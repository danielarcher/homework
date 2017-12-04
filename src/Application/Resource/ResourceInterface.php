<?php 

namespace Language\Application\Resource;

use Language\Application\Api;
use Language\Application\Config;

interface ResourceInterface
{
    public function __construct(Config $config, Api $api);

    public function getApplications();

    public function getLanguages(string $appId);

    public function getLanguageFile(string $appId, string $language);

    public function getLanguageCachePath(string $appId, string $language);
}
