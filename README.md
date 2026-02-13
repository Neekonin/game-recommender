# 🎮 Game Recommender

Aplicação web para descoberta e gerenciamento de jogos utilizando a API da RAWG.

O projeto permite importar jogos diretamente da API, armazenar no banco de dados e traduzir automaticamente gêneros e estilos utilizando a API do DeepL.


## 📌 Sobre o Projeto

O **Game Recommender** é uma aplicação desenvolvida com:

- PHP 8.4
- Laravel 11
- Vue.js
- Docker
- MySQL
- Redis
- Integração com API RAWG
- Integração com API DeepL

### 🚀 O que ele faz?

- Importa jogos da API RAWG
- Armazena dados no banco
- Traduz gêneros e estilos automaticamente
- Interface frontend para navegação dos jogos
- Gerenciamento simplificado via script `manager.sh`


## 🖼️ Preview do Projeto

![Preview do Projeto](./docs/preview.jpg)

# 🧰 Pré-requisitos

Antes de iniciar, é necessário ter instalado:

- 🐳 Docker  
- 🐳 Docker Compose  

Verifique se estão instalados:

```
docker -v
docker compose version
```

Se não estiverem instalados:

Docker:
https://www.docker.com/products/docker-desktop/

# 🔑 Configuração das APIs

O próprio `manager.sh` possui uma opção para configurar as chaves automaticamente.

Ele:

- Cria o `.env` se não existir
- Remove chaves antigas
- Solicita as novas chaves
- Atualiza o .env com elas


## Onde obter as chaves?

RAWG API  
https://rawg.io/apidocs  

DeepL API  
https://www.deepl.com/pro-api  


# ⚙️ Como Rodar o Projeto

O projeto possui um script inteligente chamado:

```
manager.sh
```

Ele automatiza todo o processo de setup e execução.


## 🔹 1️⃣ Clone o repositório

```
git clone https://github.com/seu-usuario/seu-repositorio.git
cd seu-repositorio
```

## 🔹 2️⃣ Dê permissão ao manager

```
chmod +x manager.sh
```

## 🔹 3️⃣ Execute o Manager

```
./manager.sh
```

## 🔹 4️⃣ Execute as opções na seguinte ordem:

```
1 → Subir Containers
4 → Configurar API Keys
5 → Instalar Dependências
6 → Rodar Migrations
7 → Importar Jogos
8 → Traduzir Gêneros e Estilos
9 → Rodar Frontend
```

Após isso, a aplicação estará disponível em:

```
http://localhost:8000
```