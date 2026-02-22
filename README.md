<p align="center">
  <img src="https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/postgres-%23316192.svg?style=for-the-badge&logo=postgresql&logoColor=white" alt="Postgres">
  <img src="https://img.shields.io/badge/docker-%230db7ed.svg?style=for-the-badge&logo=docker&logoColor=white" alt="Docker">
</p>

# 📋 Kanban Project - Laravel 11

Este é um projeto de Kanban simplificado, desenvolvido para gerenciamento ágil de tarefas. A aplicação utiliza o que há de mais moderno no ecossistema PHP, focando em código limpo e desacoplamento.

## 🌟 Introdução

O projeto foi construído utilizando **Laravel 11** e **PHP 8.2**. A arquitetura segue o padrão **MVC (Model-View-Controller)** reforçado por uma camada de **Services**, garantindo que as regras de negócio fiquem isoladas dos Controllers.

### Diferenciais do Projeto:

- **Arquitetura Service-Layer:** Lógica de negócio centralizada em classes de serviço.
- **Ambiente Isolado:** Configuração completa via Docker (Laravel Sail).
- **Independência de OS:** O projeto roda exatamente da mesma forma em Windows, Mac ou Linux.

---

## 🛠 Tecnologias e Dependências

Para garantir a portabilidade e performance, as seguintes tecnologias foram utilizadas:

- **Linguagem:** PHP 8.2
- **Framework:** Laravel 11
- **Banco de Dados:** PostgreSQL 15+
- **Orquestração:** Docker + Laravel Sail
- **Frontend Assets:** Bootstrap
- **Testes:** PHPUnit

---

## 🏗 Arquitetura do Software

A estrutura de pastas foi organizada para suportar o crescimento do projeto:

- **Models:** Representação das entidades e relacionamentos no banco de dados.
- **Services:** Localizados em `app/Services`, contêm toda a lógica de transição de status, validações e regras do Kanban.
- **Controllers:** Apenas orquestram a entrada de dados (Requests) e chamam os respectivos serviços.

---

## 🚀 Como Configurar e Rodar

Você precisa ter apenas o **Docker** instalado em sua máquina.

### 1. Clonar o Repositório

```bash
git clone <url-do-repositorio>
cd kanban-project
```

### 2. Configurar Variáveis de Ambiente

```bash
cp .env.example .env
```

‼️ Certifique-se de configurar as variáveis do arquivo .env após a cópia. Por padrão, o projeto será iniciado utilizando a configuração padrão do Laravel Sail.

### 3. Instalação e Containers (Laravel Sail)

Como o projeto utiliza Docker, não é necessário ter PHP ou Composer instalados localmente.

‼️ Certifique-se de que o Docker esteja instalado e em execução na sua máquina antes de continuar.

```bash
# Você pode verificar se o Docker está rodando com:
docker --version
```

### A. Instalação das dependências PHP:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

### B. Subir os Containers

```bash
./vendor/bin/sail up -d
```

### 4. Configuração Final

Com os containers rodando, execute o setup do banco de dados e chaves:

```bash
# Gerar chave da aplicação e rodar migrations
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
```

### 5. Inicializando frontend assets

Compile os arquivos de estilo e scripts (Bootstrap):

```bash
# Instalar dependências do NPM
npm install

# Iniciar frontend
npm run dev

# ou
npm run build
```

O projeto estará disponível em: http://localhost

---

### 🧪 Testes Automatizados

O projeto utiliza o PHPUnit, o framework de testes padrão do ecossistema Laravel, para garantir a integridade das regras de negócio, a estabilidade das rotas e a persistência correta dos dados.

Estrutura da Cobertura:
Unit Tests (Testes Unitários): Focados na validação isolada das regras de negócio dentro das camadas de Services e Actions, sem dependência de banco de dados.

Feature Tests (Testes de Funcionalidade): Testes de integração que simulam requisições HTTP para as rotas do Kanban, garantindo que o fluxo de movimentação de tarefas, permissões e persistência (Upsert/Update) funcionem conforme o esperado.

Database & Integrity: Verificação rigorosa das constraints do PostgreSQL e garantia de que os Factories e Seeders mantêm o estado consistente do banco.

Como rodar os testes:
Certifique-se de que o ambiente Laravel Sail esteja em execução e utilize os comandos abaixo:

```bash
# Rodar todos os testes
./vendor/bin/sail test

```

---

### Demo

https://github.com/user-attachments/assets/d4cb868d-9f27-48bf-a037-b22ae9594862

###
