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

* **Linguagem:** PHP 8.2
* **Framework:** Laravel 11
* **Banco de Dados:** PostgreSQL 15+
* **Orquestração:** Docker + Laravel Sail
* **Frontend Assets:** Bootstrap

---

## 🏗 Arquitetura do Software

A estrutura de pastas foi organizada para suportar o crescimento do projeto:



* **Models:** Representação das entidades e relacionamentos no banco de dados.
* **Services:** Localizados em `app/Services`, contêm toda a lógica de transição de status, validações e regras do Kanban.
* **Controllers:** Apenas orquestram a entrada de dados (Requests) e chamam os respectivos serviços.

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
````
### 3. Subir os Containers (Laravel Sail)
Na primeira execução, o Docker fará o build das imagens personalizadas para o PHP 8.2:
```bash 
./vendor/bin/sail up -d
````
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

O projeto estará disponível em: http://localhost

###
