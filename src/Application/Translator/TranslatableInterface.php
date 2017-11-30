<?php 

namespace Language\Application\Translator;

interface TranslatableInterface
{
	public function getLanguages();

	public function getLanguageFile(string $language);

	public function getLanguageCachePath(string $language);
}