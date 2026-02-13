#!/bin/bash

CONTAINER_NAME=game_app # Nome do Container

is_container_running() {
  docker inspect -f '{{.State.Running}}' $CONTAINER_NAME 2>/dev/null | grep true >/dev/null
}

configure_api_keys() {
  echo "🔑 Configuração das API Keys"

  # Verifica se .env existe
  if [ ! -f ".env" ]; then
    echo "⚠️  Arquivo .env não encontrado."
    echo "Criando a partir do .env.example..."
    cp .env.example .env
  fi

  # Input oculto
  echo ""
  read -s -p "Digite sua RAWG_API_KEY: " RAWG_KEY
  echo ""
  read -s -p "Digite sua DEEPL_API_KEY: " DEEPL_KEY
  echo ""

  # Validação
  if [ -z "$RAWG_KEY" ] || [ -z "$DEEPL_KEY" ]; then
    echo "❌ As chaves não podem estar vazias."
    return
  fi

  # Remove entradas antigas
  sed -i '/^RAWG_API_KEY=/d' .env
  sed -i '/^DEEPL_API_KEY=/d' .env

  # Adiciona novas
  echo "RAWG_API_KEY=${RAWG_KEY}" >> .env
  echo "DEEPL_API_KEY=${DEEPL_KEY}" >> .env

  echo "✅ API Keys configuradas com sucesso!"
}

while true; do

clear
echo "------------------------------------------"
echo "   GERENCIADOR DO PROJETO"
echo "------------------------------------------"
echo "1) Subir Containers"
echo "2) Desligar Containers"
echo "3) Ver Logs"
echo "4) Configurar API Keys"
echo "5) Instalar Dependências"
echo "6) Rodar Migrations"
echo "7) Importar Jogos (RAWG)"
echo "8) Traduzir Gêneros e Estilos"
echo "9) Rodar Frontend"
echo "10) Sair"
echo "------------------------------------------"

read -p "Escolha uma opção: " option

case $option in
  1)
    echo "🚀 Subindo os containers..."
    docker-compose up -d
    ;;

  2)
    echo "🛑 Desligando containers..."
    docker-compose down
    ;;

  3)
    docker-compose logs -f
    ;;

  4)
    configure_api_keys
    ;;

  5)
    if is_container_running; then
      echo "📦 Executando Composer Install..."
      docker exec -it $CONTAINER_NAME composer install
    else
      echo "❌ O container não está rodando."
    fi
    ;;

  6)
    if is_container_running; then
      echo "📦 Rodando Migrations..."
      docker exec -it $CONTAINER_NAME php artisan migrate
    else
      echo "❌ O container não está rodando."
    fi
    ;;

  7)
    if is_container_running; then
      read -p "Digite o número de páginas (100 jogos por página): " pages

      if [[ "$pages" =~ ^[0-9]+$ ]]; then
        echo "🎮 Importando $pages página(s)..."
        docker exec -it $CONTAINER_NAME php artisan rawg:import-games --pages=$pages
      else
        echo "❌ Número inválido."
      fi
    else
      echo "❌ O container não está rodando."
    fi
    ;;

  8)
    if is_container_running; then
      echo "🌍 Traduzindo gêneros e estilos..."
      docker exec -it $CONTAINER_NAME php artisan app:translate-genre-style
    else
      echo "❌ O container não está rodando."
    fi
    ;;

  9)
    if is_container_running; then
      echo "🔥 Iniciando Frontend..."
      docker exec -it $CONTAINER_NAME bash -c "cd resources/js && npm run dev"
    else
      echo "❌ O container não está rodando."
    fi
    ;;

  10)
    echo "👋 Encerrando..."
    break
    ;;

  *)
    echo "❌ Opção inválida"
    ;;
esac

echo ""
read -p "Pressione ENTER para voltar ao menu..."

done
