describe('Jornada de Compra do Usuário', () => {

    it('deve permitir adicionar produtos, calcular o valor com desconto e abrir o modal de checkout', () => {

        cy.visit('/');

        cy.contains('.card', 'Teclado Mecânico').find('button').click();
        cy.contains('.card', 'Mouse Gamer').find('button').click();

        cy.get('header .badge').should('be.visible').and('contain', '2');

        cy.get('header a[href="#"]').last().click();

        cy.url().should('include', '/');
        cy.contains('h2', 'Seu Carrinho').should('be.visible');
        cy.contains('h5', 'Teclado Mecânico').should('be.visible');
        cy.contains('h5', 'Mouse Gamer').should('be.visible');

        cy.get('#paymentMethod').select('pix');
        cy.get('.summary-box').should('contain', 'R$ 360.00');

        cy.contains('button', 'Finalizar Compra').click();

        cy.get('.modal').should('be.visible');
        cy.contains('.modal-title', 'Resumo da Compra');
        cy.get('.modal-body').should('contain', 'R$ 360.00');
        cy.get('.modal .btn-close').click();


        cy.get(':nth-child(2) > .flex-grow-1 > .input-group > :nth-child(3)').click();
        cy.get('#paymentMethod').select('credit_card');
        cy.get('.summary-box').should('contain', 'R$ 585.00');


        cy.contains('button', 'Finalizar Compra').click();

        cy.get('.modal').should('be.visible');
        cy.contains('.modal-title', 'Resumo da Compra');
        cy.get('.modal-body').should('contain', 'R$ 585.00');
        cy.get('.modal .btn-close').click();


        cy.get(':nth-child(2) > .flex-grow-1 > .input-group > :nth-child(1)').click();
        cy.get(':nth-child(3) > .flex-grow-1 > .input-group > :nth-child(3)').click();
        cy.get('#paymentMethod').select('credit_card');
        cy.get('#installments').select('5')
        cy.get('.summary-box').should('contain', 'R$ 578.06');


        cy.get("option[value='5']")

        cy.contains('button', 'Finalizar Compra').click();

        cy.get('.modal').should('be.visible');
        cy.contains('.modal-title', 'Resumo da Compra');
        cy.get('.modal-body').should('contain', 'R$ 578.06');
        cy.get("div[class*='mt-3']").should('contain', 'Pagamento em 5x de R$ 115.61')
    });
});
