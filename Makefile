.PHONY: help setup up down build logs test test-e2e test-all artisan watch

help:
	@echo "Comandos disponíveis:"
	@echo "  make setup         - 🚀 Executa a configuração inicial completa do projeto."
	@echo "  make up            - Sobe os contêineres Docker em background."
	@echo "  make down          - Para todos os contêineres."
	@echo "  make build         - Constrói ou reconstrói as imagens e sobe os contêineres."
	@echo "  make watch         - Inicia o servidor de desenvolvimento do Vite (frontend)."
	@echo "  make logs          - Exibe os logs de todos os serviços."
	@echo "  make test          - Executa os testes do PHPUnit (backend)."
	@echo "  make test-e2e      - Abre a interface do Cypress (End-to-End)."
	@echo "  make test-all      - Roda todos os testes (backend e E2E)."
	@echo "  make artisan cmd=\"\"    - Executa um comando artisan. Ex: make artisan cmd=\"migrate:fresh --seed\""

setup: build
	@echo "-> Configurando ambiente pela primeira vez..."
	@cp -n .env.example .env || true
	@echo "-> Instalando dependências do Composer..."
	@docker compose exec php composer install
	@echo "-> Instalando dependências do Node..."
	@docker compose exec php npm install
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

watch: ## Inicia o servidor de desenvolvimento do Vite (frontend)
	@echo "-> Iniciando o servidor de desenvolvimento do Vite..."
	@docker compose exec php npm run dev

logs: ## Exibe os logs de todos os serviços
	@docker compose logs -f

test: ## Executa os testes do PHPUnit (backend)
	@echo "-> Executando testes do PHPUnit..."
	@docker compose exec php ./vendor/bin/phpunit

test-e2e: ## Abre a interface do Cypress para testes End-to-End
	@echo "-> Abrindo interface do Cypress..."
	@docker compose exec php ./vendor/bin/cypress open

test-all: test test-e2e ## Roda todos os testes

artisan: ## Executa um comando artisan
	@echo "-> Executando: php artisan $(cmd)"
	@docker compose exec php php artisan $(cmd)
