<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Genre;
use App\Models\Style;
use App\Services\TranslationService;

class TranslateGenreStyle extends Command
{
    protected $signature = 'app:translate-genre-style';
    protected $description = 'Traduz os nomes de Gêneros e Estilos para PT-BR';

    public function handle(TranslationService $translator)
    {
        $this->info('Iniciando tradução de Gêneros...');
        $this->translateTable(Genre::all(), $translator);

        $this->info('Iniciando tradução de Estilos...');
        $this->translateTable(Style::all(), $translator);

        $this->info('Processo concluído!');
        return Command::SUCCESS;
    }

    private function translateTable($items, $translator)
    {
        foreach ($items as $item) {
            $originalName = $item->name;
            $translatedName = $translator->translate($originalName, 'PT-BR');

            if ($translatedName !== $originalName) {
                $item->update([
                    'name' => $translatedName
                ]);

                $this->line("Traduzido: {$originalName} -> {$translatedName}");
            }
        }
    }
}