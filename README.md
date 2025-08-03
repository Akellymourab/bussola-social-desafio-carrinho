# Projeto-Base: Laravel com MySQL e Docker

Este é um template completo para iniciar projetos backend com Laravel, utilizando um ambiente totalmente conteinerizado com Docker, Nginx e MySQL.

## Como Usar Este Template

Qualquer pessoa pode clonar este repositório e, com um único comando, ter um ambiente de desenvolvimento Laravel completo e funcional.

### Pré-requisitos
* [Docker](https://www.docker.com/get-started)
* `make` (nativo em Linux/macOS)

### Instruções de Setup

**1. Clone o Repositório**
```bash
git clone https://github.com/Akellymourab/laravel-MySQL-base-project.git
cd laravel-mysql-base-project
````

**2. Execute o Comando de Setup**
Este comando irá criar seu arquivo `.env`, subir os contêineres, instalar todas as dependências, configurar o Laravel e ajustar as permissões.

```bash
make setup
```

Aguarde o processo terminar.

**Pronto\! O ambiente está no ar.**

### Endpoints Disponíveis

* **Aplicação Laravel**: [http://localhost:8080](http://localhost:8080)

## Comandos Úteis (Makefile)

Use o comando `make help` para ver a lista completa de atalhos disponíveis.

* Subir os contêineres:

```bash
make up
```

* Parar todos os contêineres:

```bash
make down
```

* Reconstruir e subir os contêineres:

```bash
make build
```

* Executar os testes (PHPUnit):

```bash
make test
```

* Executar um comando Artisan específico:

```bash
make artisan cmd="migrate:fresh --seed"
```

* Acompanhar os logs de todos os serviços:

```bash
make logs
```
