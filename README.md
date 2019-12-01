# Coding Test - Telium

## Instruções Gerais

Neste teste serão avaliadas sua capacidade de compreensão, análise, interpretação e resolução do problema proposto abaixo.

Queremos entender como você trabalha, então dois pontos principais que serão avaliados neste teste são seus códigos e seus commits.

## Ferramentas de terceiro

Não temos problema com utilização de soluções prontas, afinal, nao reinventamos a roda todos os dias.

Você pode utilizar qualquer solucao que preferir, qualquer comando do artisan, stack overflow, pacote do composer ou não, o que estiver à mão para facilitar seu trabalho. Mas, favor, identificar e justificar códigos de terceiros sendo utilizados para que possamos saber o que é seu código e o que é código terceiro e, assim, entender sua decisão.

## Instruções de envio

Faça um fork do projeto para seu github e finalizado o desenvolvimento, faça um pull request para o projeto principal.

Além do seu código, envie instruções detalhadas de como proceder para colocar seu projeto para funcionar.

## Contato

Qualquer dúvida, critica ou sugestão que voce tiver, favor enviar um email para ti@telium.com.br, que lhe auxiliaremos dentro do possível.

## Prazo

Você tem DEZ dias para a realização desse desafio. Se precisar de mais tempo, basta avisar para negociarmos um novo prazo.

# O problema

Precisamos que você desenvolva uma API REST, em Laravel 5.4 (ou maior) e PHP 7, que irá servir de apoio a um sistema de gerenciamento de diversas lojas.

O sistema será utilizado por lojas e seus funcionários. Esse funcionário associado deve receber um email avisando-o que foi registrado na plataforma. Fique livre para propor a modelagem da relação lojas e funcionários.

O funcionário deve ser capaz de realizar o CRUD de:

- Produtos: código, nome, descrição, quantidade em estoque, preço e atributos que podem variar de produto para produto;
- Pedidos: codigo do pedido, data da compra, nome do comprador, status do pedido (novo, pago, entregue e cancelado), valor do frete e lista de itens do pedido (produto, quantidade e preço);

O sistema deve fornecer os seguintes relatórios, para cada loja:

- Produtos mais vendidos;
- Produtos com baixo estoque (estoque menor que 3);
- Ticket médio (você pode utilizar a formula Valor Total de Vendas/Numero de Vendas, mas pode sugerir outro calculo para definir o ticket médio. Caso decida utilizar outra formula, favor especificar qual)

Considerações importantes:

- Não permitir criação de pedido com um produto inexistente;
- Não permitir criação de pedido com um produto que não está disponivel em estoque;
- Manter o estoque de cada loja atualizado de acordo com os pedidos;
- O sistema deve exigir a autenticação do funcionário, quando necessário;
- Dados de inserção devem ser validadas;
- Erros devem ser tratados;
- Sistema deve ser seguro e as suas informações, consistentes

## Pontos Obrigatórios

- SOLID;
- Design Patterns;

Não esqueça de informar quais padrões foram utilizados e exemplifique sua utilização no código. Você não precisa utilizar todos os possíveis, mas queremos saber quais você sabe utilizar.

## Pontos extras

- Enviar o projeto com um Docker apropriado para rodar o seu desafio e as instruções pertinentes para seu funcionamento;
- TDD;
- PSRs;
