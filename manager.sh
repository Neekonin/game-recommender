#!/bin/bash

echo "------------------------------------------"
echo "   GERENCIADOR DO PROJETO GAME"
echo "------------------------------------------"
echo "1) Subir Containers (Docker Up)"
echo "2) Desligar Containers (Docker Down)"
echo "3) Ver Logs do Sistema"
echo "4) Sair"
echo "------------------------------------------"
read -p "Escolha uma opção: " opcao

case $option in
  1)
    echo "🚀 Subindo os containers..."
    docker-compose up -d
    echo "✅ Containers rodando em http://localhost:8000"
    ;;
  2)
    echo "🛑 Desligando tudo..."
    docker-compose down
    echo "✅ Tudo desligado."
    ;;
  3)
    docker-compose logs -f
    ;;
  4)
    exit
    ;;
  *)
    echo "❌ Opção inválida"
    ;;
esac