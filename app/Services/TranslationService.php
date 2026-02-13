<?php

namespace App\Services;

use DeepL\Translator;

class TranslationService
{
    /**
     * @var Translator
    */
    protected $translator;

    /**
     * Inicializa o tradutor usando a chave de API configurada em config/services.php.
    */
    public function __construct()
    {
        $this->translator = new Translator(config('services.deepl.key'));
    }

    /**
     * Traduz um texto para o idioma de destino.
     * @param string $text O conteúdo a ser traduzido.
     * @param string $targetLang O código do idioma (Ex: 'PT-BR', 'EN-US').
     * @return string Texto traduzido ou o texto original em caso de falha.
    */
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