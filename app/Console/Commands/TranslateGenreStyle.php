<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Genre;
use App\Models\Style;
use App\Services\TranslationService;

class TranslateGenreStyle extends Command
{
    /**
     * A assinatura do comando.
     * @var string
    */
    protected $signature = 'app:translate-genre-style';

    /**
     * A descrição do comando exibida na listagem do artisan.
     * @var string
    */
    protected $description = 'Traduz os nomes de Gêneros e Estilos para PT-BR';

    /**
     * Executa a lógica do comando.
     * @param TranslationService $translator Serviço que realiza a integração com APIs de tradução
     * @return int
    */
    public function handle(TranslationService $translator)
    {
        $this->info('Iniciando tradução de Gêneros...');
        $this->translateTable(Genre::all(), $translator);

        $this->info('Iniciando tradução de Estilos...');
        $this->translateTable(Style::all(), $translator);

        $this->info('Processo concluído!');
        return Command::SUCCESS;
    }

    /**
     * Itera sobre uma coleção de modelos e atualiza seus nomes se houver tradução disponível.
     * @param Collection $items Coleção de Genre ou Style
     * @param TranslationService $translator Serviço que realiza a integração com APIs de tradução
     * @return void
    */
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