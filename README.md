<p align="center">
  <img src="https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
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
- **Testes:** PEST

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
cd kanban_project
```

### 2. Configurar Variáveis de Ambiente

```bash
cp .env.example .env
```

### 3. Subir os Containers (Laravel Sail)

Na primeira execução, o Docker fará o build das imagens personalizadas para o PHP 8.2:

```bash
./vendor/bin/sail up -d
```

### 4. Instalação e Migrações

Com os containers ativos, rode os comandos abaixo para finalizar a configuração:

```bash
# Instalar dependências do Composer
./vendor/bin/sail composer install

# Gerar chave da aplicação
./vendor/bin/sail artisan key:generate

# Rodar as migrações do PostgreSQL
./vendor/bin/sail artisan migrate
```

### 5. Inicializando frontend assets

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

O projeto utiliza o PEST PHP, um framework de testes focado em simplicidade e elegância, para garantir a integridade das regras de negócio e das rotas da aplicação.

Cobertura de Testes:
Unitários: Validação das regras de negócio dentro das camadas de Services.

Feature: Testes de integração das rotas do Kanban, garantindo que o fluxo de movimentação de tarefas e persistência de dados (Upsert/Update) funcione corretamente.

Database: Verificação de integridade e constraints do PostgreSQL.

Como rodar os testes:
Certifique-se de que os containers do Laravel Sail estejam ativos e execute:

```bash
# Rodar todos os testes
./vendor/bin/sail pest

# Rodar os testes com o relatório de cobertura (Coverage)
./vendor/bin/sail pest --coverage

# Rodar apenas um grupo específico de testes
./vendor/bin/sail pest --group=kanban
```

---

### Demo

###
