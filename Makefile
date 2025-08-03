.PHONY: help setup up down build logs test artisan

help:
	@echo "Comandos disponíveis:"
	@echo "  make setup         - 🚀 Executa a configuração inicial completa do projeto."
	@echo "  make up            - Sobe os contêineres Docker em background."
	@echo "  make down          - Para todos os contêineres."
	@echo "  make build         - Constrói ou reconstrói as imagens e sobe os contêineres."
	@echo "  make logs          - Exibe os logs de todos os serviços."
	@echo "  make test          - Executa os testes do PHPUnit no php."
	@echo "  make artisan cmd=\"\"    - Executa um comando artisan. Ex: make artisan cmd=\"migrate:fresh --seed\""

setup: build
	@echo "-> Configurando ambiente pela primeira vez..."
	@cp -n .env.example .env || true
	@echo "-> Instalando dependências do Composer..."
	@docker compose exec php composer install
	@echo "-> Gerando chave da aplicação Laravel..."
	@docker compose exec php php artisan key:generate
	@echo "-> Limpando caches do Laravel..."
	@docker compose exec php php artisan optimize:clear
	@echo "-> Rodando as migrations do banco de dados..."
	@docker compose exec php php artisan migrate
	@echo "-> Ajustando permissões das pastas..."
	@docker compose exec php chmod -R 777 storage bootstrap/cache
	@echo "\n✅ Projeto configurado com sucesso! Ambiente pronto para uso. ✅\n"

up: ## Sobe os contêineres Docker em background
	@docker compose up -d

down: ## Para todos os contêineres
	@docker compose down

build: ## Constrói ou reconstrói as imagens e sobe os contêineres
	@docker compose up -d --build

logs: ## Exibe os logs de todos os serviços
	@docker compose logs -f

test: ## Executa os testes do PHPUnit no php
	@echo "-> Executando testes do PHPUnit..."
	@docker compose exec php ./vendor/bin/phpunit

artisan: ## Executa um comando artisan
	@echo "-> Executando: php artisan $(cmd)"
	@docker compose exec php php artisan $(cmd)
