<?php 

namespace Language\Application;

interface ITranslatableApplication
{
	public function getLanguages();

	public function getLanguageFile();

	public function getLanguageCachePath();
}