.PHONY: help setup up down build logs test test-e2e test-all artisan dev cs cs-fix docs db-refresh

help:
	@echo "Comandos disponíveis:"
	@echo "  make setup         - 🚀 Executa a configuração inicial completa do projeto."
	@echo "  make up            - Sobe os contêineres Docker em background."
	@echo "  make down          - Para todos os contêineres."
	@echo "  make build         - Constrói ou reconstrói as imagens e sobe os contêineres."
	@echo "  make dev         	- Inicia o servidor de desenvolvimento do Vite (frontend)."
	@echo "  make logs          - Exibe os logs de todos os serviços."
	@echo "  make permissions   - Ajusta as permissões dos arquivos para o usuário do contêiner."
	@echo "  make db-refresh    - 🚮 Apaga, recria e popula o banco de dados."
	@echo "  make test          - Executa os testes do PHPUnit (backend)."
	@echo "  make test-e2e-run  - Roda os testes E2E com Cypress no terminal (headless)."
	@echo "  make test-e2e-open - 🖥️  Abre a interface gráfica do Cypress para testes interativos."
	@echo "  make cs            - 🎨 Verifica o estilo de código com o Pint (PSR-12)."
	@echo "  make cs-fix        - ✨ Corrige o estilo de código automaticamente com o Pint."
	@echo "  make docs          - 📚 Gera a documentação da API (Swagger)."
	@echo "  make artisan cmd=\"\"    - Executa um comando artisan. Ex: make artisan cmd=\"migrate:fresh --seed\""

setup: build
	@echo "-> Configurando ambiente pela primeira vez..."
	@cp -n .env.example .env || true
	@echo "-> Instalando dependências do Composer..."
	@docker compose exec php composer install
	@echo "-> Instalando dependências do Node..."
	@docker compose exec php npm install
	@npm install
	@echo "-> Gerando chave da aplicação Laravel..."
	@docker compose exec php php artisan key:generate
	@echo "-> Limpando caches do Laravel..."
	@docker compose exec php php artisan optimize:clear
	@echo "-> Rodando as migrations e seeders..."
	@docker compose exec php php artisan migrate --seed
	@echo "-> Ajustando permissões das pastas..."
	@docker compose exec php chown -R developer:developer storage bootstrap/cache
	@echo "\n✅ Projeto configurado com sucesso! Ambiente pronto para uso. ✅\n"

build: ## Constrói ou reconstrói as imagens e sobe os contêineres
	@docker compose up -d --build

up: ## Sobe os contêineres Docker em background
	@docker compose up -d

down: ## Para todos os contêineres
	@docker compose down


dev: ## Inicia o servidor de desenvolvimento do Vite (frontend)
	@echo "-> Iniciando o servidor de desenvolvimento do Vite..."
	@docker compose exec php npm run dev

logs: ## Exibe os logs de todos os serviços
	@docker compose logs -f

permissions: ## Ajusta as permissões dos arquivos para o usuário do contêiner
	@echo "-> Ajustando permissões da pasta do projeto..."
	@docker compose exec -u root php chown -R developer:developer /var/www/html
	@echo "✅ Permissões ajustadas!"


db-refresh: ## Apaga, recria e popula o banco de dados
	@echo "-> Recriando e populando o banco de dados..."
	@make artisan cmd="migrate:fresh --seed"
	@echo "✅ Banco de dados recriado com sucesso!"

test: ## Executa os testes do PHPUnit (backend)
	@echo "-> Executando testes do PHPUnit..."
	@docker compose exec php ./vendor/bin/phpunit --testdox

test-e2e-run: ## Roda os testes E2E com Cypress no terminal (headless)
	@echo "-> Executando testes E2E com Cypress (headless)..."
	@npx cypress run

test-e2e-open: ## Abre a interface gráfica do Cypress para testes interativos
	@echo "-> Abrindo a interface do Cypress..."
	@npx cypress open

test-all: test test-e2e ## Roda todos os testes

cs: ## Verifica o estilo de código com o Pint
	@echo "-> Verificando estilo de código (PSR-12)..."
	@docker compose exec php ./vendor/bin/pint --test -v

cs-fix: ## Corrige o estilo de código automaticamente
	@echo "-> Corrigindo estilo de código com o Pint..."
	@docker compose exec php ./vendor/bin/pint

docs: ## Gera a documentação da API
	@echo "-> Gerando documentação da API (Swagger)..."
	@make artisan cmd="l5-swagger:generate"
	@echo "✅ Documentação gerada com sucesso!"

artisan: ## Executa um comando artisan
	@echo "-> Executando: php artisan $(cmd)"
	@docker compose exec php php artisan $(cmd)
