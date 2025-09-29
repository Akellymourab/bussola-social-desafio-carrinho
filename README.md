# Desafio Técnico: Carrinho de Compras - Bússola Social 🛒

![Status da CI/CD](https://github.com/Akellymourab/bussula-social-desafio-carrinho/actions/workflows/ci.yml/badge.svg)

Olá! 👋 Bem-vindo(a) à documentação deste projeto.

Esta é uma solução completa para o desafio técnico da Bússola Social, implementando um módulo de carrinho de compras com um backend robusto em **Laravel 12** e um frontend reativo e desacoplado em **Vue.js 3**. O ambiente é totalmente conteinerizado com **Docker**, garantindo uma experiência de desenvolvimento consistente e livre de complicações.

O objetivo foi criar um software que não apenas funciona, mas que é limpo, bem estruturado, testável e fácil de manter, seguindo os princípios do Clean Code.

---

### 🏛️ Decisões de Arquitetura (O "Porquê" das Coisas)

Boas ferramentas são importantes, mas a forma como as usamos é o que define a qualidade do software. Aqui estão as principais decisões por trás da estrutura deste projeto:

#### Backend
-   **Responsabilidades Claras (SOLID):** Em vez de colocar toda a lógica no Controller, as regras de negócio complexas (cálculos de desconto e juros) foram isoladas em uma classe de Serviço (`CalculationService`). Isso torna o Controller mais limpo e a lógica de negócio muito mais fácil de testar unitariamente.

-   **Validação Centralizada e Segura (Form Requests):** A validação dos dados que chegam na API é feita por uma classe `CalculateCartRequest`. Essa abordagem do Laravel organiza as regras, aumenta a segurança e mantém o Controller focado em sua principal tarefa: orquestrar a requisição.

-   **Contrato de API Consistente:** Toda a comunicação entre frontend e backend (chaves de JSON, rotas) segue o padrão em inglês para consistência e alinhamento com as convenções globais de desenvolvimento.

-   **Chega de "Strings Mágicas" (Enums):** Para métodos de pagamento, foi utilizado um `Enum` do PHP 8+ (`PaymentMethod`). Isso evita erros de digitação (ex: `'PIX'` vs `'pix'`), torna o código mais legível e muito mais seguro para dar manutenção.

#### Frontend
-   **Arquitetura de Componentes:** A interface foi dividida em componentes reutilizáveis e com responsabilidades únicas (`Header`, `ProductListPage`, `CartPage`, `CheckoutModal`), facilitando a manutenção e o desenvolvimento.

-   **Gerenciamento de Estado Reativo:** O estado do carrinho é gerenciado de forma centralizada no arquivo `store.js` usando a Composition API do Vue (`reactive`, `computed`). Isso garante que qualquer alteração no carrinho seja refletida em toda a aplicação de forma automática e eficiente.

-   **Comunicação Centralizada com a API:** Todas as chamadas `axios` são feitas através de um módulo `api.js` centralizado. Isso evita a duplicação de URLs e configurações, e facilita a adição de interceptors ou headers de autenticação no futuro.

-   **Automação para Desenvolvedores (Makefile):** Para que ninguém precise decorar comandos longos de Docker ou Artisan, um `Makefile` foi criado. Com atalhos simples como `make setup` e `make test`, a produtividade aumenta e a chance de erros diminui.

---

### ✨ Tecnologias Utilizadas

| Categoria          | O que foi usado                         |
| ------------------ | --------------------------------------- |
| **Backend** | PHP 8.4, Laravel 12                     |
| **Frontend** | Vue.js 3, Vite, Bootstrap 5             |
| **Banco de Dados** | MySQL 8                                 |
| **Ambiente** | Docker, Nginx, Makefile                 |
| **Testes** | PHPUnit (Unitário), Cypress (E2E)       |
| **Qualidade** | Laravel Pint (PSR-12)                   |
| **Documentação** | Swagger (OpenAPI via L5-Swagger)        |
| **CI/CD** | GitHub Actions                          |

---

### ✅ Pré-requisitos

Para rodar este projeto, você só precisa ter o seguinte instalado e rodando na sua máquina:

-   **Docker** e **Docker Compose**
-   **make** (nativo em Linux/macOS)

---

### 🚀 Como Rodar o Projeto (Guia Rápido)

Com o `Makefile`, tudo fica mais simples.

#### 1. Clone o Repositório
```bash
git clone https://github.com/Akellymourab/bussola-social-desafio-carrinho.git
cd bussola-social-desafio-carrinho
```

#### 2. Execute o Setup Automatizado
Este comando único prepara todo o ambiente para você: sobe os contêineres, instala as dependências (Composer e NPM), configura o `.env` e popula o banco de dados.
```bash
make setup
```

#### 3. Inicie o Servidor do Frontend
Em um **novo terminal**, na mesma pasta, rode o comando abaixo. Ele ficará monitorando seus arquivos do Vue.js.
```bash
make dev
```

Pronto! Seu ambiente de desenvolvimento está 100% funcional.

---

### 🌐 Onde Acessar

-   **Aplicação Vue.js (Frontend):** ➡️ [http://localhost:8080](http://localhost:8080)
-   **Documentação da API (Swagger):** ➡️ [http://localhost:8000/api/documentation](http://localhost:8000/api/documentation)

---

### 🛠️ Comandos Úteis do Dia a Dia (Makefile)

Use `make help` para ver todos os atalhos. Aqui estão os principais:

| Comando | O que faz |
|---|---|
| `make up` / `make down` | Sobe e desce os contêineres Docker. |
| `make test` | Roda todos os testes do backend (PHPUnit). |
| `make test-e2e-run` | Roda os testes E2E com Cypress no terminal. |
| `make cs-fix` | Corrige automaticamente o estilo do código para o padrão PSR-12. |
| `make db-refresh`| Limpa e repopula o banco de dados do zero. |
| `make artisan cmd="..."` | Executa qualquer comando Artisan que você precisar. |

---

### ⚙️ Qualidade de Código e CI/CD

A qualidade é garantida de forma automática. Este repositório usa **GitHub Actions** para rodar um pipeline de Integração Contínua a cada `push` ou `pull request`. O robô guardião verifica duas coisas:

1.  **Testes (PHPUnit):** Confere se a aplicação continua funcionando como deveria.
2.  **Padrão de Código (Pint):** Garante que o código está sempre limpo e consistente.

Se algo falhar, o GitHub avisa, garantindo que só código de alta qualidade chegue na branch principal.

---

### 👩‍💻 Autora

Desenvolvido por **Kelly Moura**.

-   **LinkedIn:** `https://www.linkedin.com/in/kellymoura-developer/`
-   **GitHub:** `https://github.com/Akellymourab`
