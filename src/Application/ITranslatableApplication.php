<?php 

namespace Language\Application;

interface ITranslatableApplication
{
	public function getLanguages();

	public function getLanguageFile(string $language);

	public function getLanguageCachePath(string $language);
}