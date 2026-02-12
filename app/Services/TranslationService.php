<?php

namespace App\Services;

use DeepL\Translator;

class TranslationService
{
    protected $translator;

    public function __construct()
    {
        $this->translator = new Translator(config('services.deepl.key'));
    }

    public function translate(string $text, string $targetLang = 'PT-BR'): string
    {
        try {
            $result = $this->translator->translateText($text, null, $targetLang);
            return $result->text;
        } catch (\Exception $e) {
            report($e);
            return $text;
        }
    }
}