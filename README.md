# Locadora de Carros

> Sistema de Locação de Veículos utilizando Laravel

## Baixar o projeto

Primeiro passo, clonar o projeto:

```bash
# Clonar
git clone https://github.com/martinsllm/app_controle_tarefas.git

# Acessar
cd app_controle_tarefas
```

## Configuração - Backend

```bash
# Instalar dependências do projeto
composer install

# Configurar variáveis de ambiente
cp .env.example .env
php artisan key:generate

# Criar migrations (tabelas)
php artisan migrate

# Rodar o backend em ambiente local
php artisan serve

```

## Configuração - Frontend

```bash
# Atualizar dependências
npm install

# Rodar em ambiente local localhost:8080
npm run dev

# Rodar em ambiente de produção
npm run build
```
