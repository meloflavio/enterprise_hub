# Enterprise Hub

Projeto simples de um sistema com autenticação e cadastro de empresas com dois tipos de usuario: **Administrador** com permissões de gerenciar as empresas e **Usuario comum** com permissão de apenas leitura. Utilizando:
1. PHP 8.3
1. Composer 2
1. Symfony 6
1. Docker
1. Caddy
1. MariaDB

## Instalação

Este guia fornece instruções para instalar o projeto de três maneiras diferentes. Escolha o método que melhor se adequa às suas necessidades ou ambiente de desenvolvimento.

### Usando Comandos Make

Os comandos make foram configurados para funcionar com o `docker compose`. Caso você utilize `docker-compose`, altere a segunda linha do arquivo Makefile para: `DOCKER_COMP = APP_ENV=dev HTTP_PORT=8000 HTTPS_PORT=443 SERVER_NAME=http://localhost docker-compose` 
1. Execute `make build` para construir imagens novas
1. Execute `make up` para iniciar o projeto
1. Abra `http://localhost:8000`, utilize o usuario `admin` e senha `admin` para acessar o sistema
1. Execute `make down` para parar os contêineres Docker.

### Usando Docker

1. Execute `docker compose build --no-cache` para construir imagens novas
1. Execute `docker compose up --pull always -d --wait` para iniciar o projeto
1. Abra `https://localhost` no seu navegador web favorito e que aceite o certificado TLS gerado automaticamente, utilize o usuario `admin` e senha `admin` para acessar o sistema
1. Execute `docker compose down --remove-orphans` para parar os contêineres Docker.

Caso seu navegador nao suporte o certificado TLS gerado automaticamente, execute o docker compose com o comando `HTTP_PORT=8000 SERVER_NAME=http://localhost docker compose up --pull always -d --wait` e abra `http://localhost:8000`,  caso o navegador continuar tentando abrir com HTTPS abra em uma aba anônima.

### Usando Symfon CLI
### 1 - Instale o symfony CLI seguindo as instruções em https://symfony.com/download

### 2 - Execute este comando na pasta raiz para instalar os pacotes:
```bash
symfony composer install
```
### 3 - Altere a variável de ambiente `DATABASE_URL` no arquivo `.env` para a sua conexão com o banco de dados

### 4 -  Crie o banco de dados. Este comando irá criar o banco de dados com o nome informado na variável `DATABASE_URL`:
```bash
symfony console doctrine:database:create
```

### 5 - Execute este comando para utilizar os arquivos de migração e criar as tabelas com suas colunas:
```bash
symfony console doctrine:migrations:diff
```

### 6 - Execute a aplicação com o comando:
```bash
symfony server:start 
```
### 7 - Abra `http://localhost:8000` no seu navegador ou digite o comando `symfony open:local` para abrir automaticamente

## Observações
Há também a possibilidade de utilizar o login de usuario comum com login `user` e senha `user`, porém o usuario comum só tem acesso à lista e detalhes de empresas cadastradas.
