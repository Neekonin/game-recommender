<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RawgService
{
    /** 
     * @var string URL base da API
    */
    protected string $baseUrl;

    /** 
     * @var string Chave de autenticação
    */
    protected string $apiKey;

    /**
     * Inicializa o serviço carregando as credenciais das configurações do sistema.
    */
    public function __construct()
    {
        $this->baseUrl = config('services.rawg.url');
        $this->apiKey = config('services.rawg.key');
    }

    /**
     * Obtém uma lista paginada de jogos.
     * @param int $page Número da página para importação.
     * @return array Resposta da API contendo a lista de jogos e metadados.
    */
    public function games(int $page = 1)
    {
        return Http::get("{$this->baseUrl}/games", [
            'key' => $this->apiKey,
            'page' => $page,
            'page_size' => 100,
        ])->json();
    }

    /**
     * Busca informações detalhadas de um jogo específico.
     * * @param int $id ID do jogo na RAWG.
     * @return array
    */    
    public function gameInfo(int $id)
    {
        return Http::get("{$this->baseUrl}/games/{$id}", [
            'key' => $this->apiKey,
        ])->json();
    }

    /**
     * Obtém as URLs de lojas onde o jogo está disponível para compra.
     * * @param int $id ID do jogo na RAWG.
     * @return array
    */
    public function gameStoresUrl(int $id)
    {
        return Http::get("{$this->baseUrl}/games/{$id}/stores", [
            'key' => $this->apiKey,
        ])->json();
    }

    /**
     * Recupera trailers e vídeos associados ao jogo.
     * * @param int $id ID do jogo na RAWG.
     * @return array
    */
    public function gameTrailer(int $id)
    {
        return Http::get("{$this->baseUrl}/games/{$id}/movies", [
            'key' => $this->apiKey,
        ])->json();
    }
}
