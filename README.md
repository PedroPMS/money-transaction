# Sistema de Transações Monetárias

## Index
- [Usuários](#Usuários)
- [Transações](#Transações)
- [Fluxo de Transações](#Fluxo-de-Transações)
    - [Fluxo de Transações Rejeitas](#Fluxo-de-Transações-Rejeitas)
    - [Fluxo de Transações Aprovadas](#Fluxo-de-Transações-Aprovadas)
- [Serviços externos indisponíveis](#Serviços-externos-indisponíveis)
- [Como rodar o sistema](#como-rodar-o-sistema)
- [Endpoints](#endpoints)
- [O que pode ser melhorado](#o-que-pode-ser-melhorado)

## Objetivos

Para este sistema busquei alcançar alguns princípios de qualidade de código e arquitetura para que o sistema seja de fácil manutenção e possibilite uma rápida expansão.
Para isso foram levantados os seguintes objetivos:

1. Utilização de testes para garantir o funcionamento das funções do sistema possibilitando uma manutenção mais rápida e precisa.
2. Utilização de uma arquitetura baseada na [Onion Architecture](https://www.codeguru.com/csharp/understanding-onion-architecture/), para separar os domínios do sistema.
3. Baixo acoplamento com o framework, libs e serviços externos. Utilizando o [Dependency Inversion Principle](https://medium.com/desenvolvendo-com-paixao/o-que-%C3%A9-solid-o-guia-completo-para-voc%C3%AA-entender-os-5-princ%C3%ADpios-da-poo-2b937b3fc530) do SOLID.  
4. Utilização de um ambiente 100% virtualizado com Docker e Makefile para facilitar a experiência do dev.
5. Documentação das funções do sistema e fluxos para que um novo desenvolvedor se adaptar rapidamente as regras de negócio.

## Usuários

No sistema, podem ser cadastrados usuários do tipo comum e lojista. Ambos possuem uma carteira zerada que é criada assim que o usuário é registrado.

Uma regra de negócio definiu que usuário do tipo lojista só podem receber transações. Enquanto usuários comuns podem fazer e receber. 

Como o teste foca no domínio de transações, não me preocupei muito com o domínio de usuário, por isso só foram implementadas as funcionalidades básicas neste domínio. 

## Transações

Para manter um histórico de trasações do usuário, as transações possuem 3 status: `created`, `succeeded` e `rejected`. Dessa forma podemos verificar o histórico de um usuário e
tomar ações para cada tipo de status.

A transação é registrada com o status de `created`, após isso ela vai para validação. Se for aprovada, ela continua o fluxo, caso o contrário ela vai para o fluxo de transações rejeitadas.

![image](https://user-images.githubusercontent.com/48099126/215920551-1ddb6bc1-fe5c-4dd4-8c1b-8e5a63705a18.png)

## Fluxo de Transações

Para iniciar uma transação é feito um request no endpoint `transaction`, esse endpoint dispara um job para a fila que vai processar essa transação.

No início do processamento, a transação é persistida no banco, o pagador é identificado e a transação vai para validação.

Após isso, o fluxo principal se divide em dois sub fluxos que são comentados a seguir:

### Fluxo de Transações Rejeitas

Um transação pode ser rejeitada pelo seguintes motivos:

1. O usuário pagador é um logísta
2. O usuário pagador não tem saldo suficiente
3. O autorizador externo não aprovou a transação

Caso acontece algum desses casos, a transação é marcaada como `rejected` e é enviada uma notificação para o usuário pagador informando o motivo da rejeição.

### Fluxo de Transações Aprovadas

Caso a transação seja aprovada, ela vai para o fluxo de transferencia de dinheiro. Nesse fluxo, é feito o crédito e o débito da trasação e a transação é marcada como `succeded`.
Esse processo ocorre dentro de uma transação de banco de dados, para evitar divergências nas carteiras.

Após isso é disparada um job para enviar uma notificação para o recebedor.

## Serviços externos indisponíveis

O fluxo precisa de serviços externos, como o autorizador e o notificador. Porém, pode ocorrer desses serviços ficarem indiponíveis.
Nessa hora entram as ações que podem ser tomadas de acordo com o status, por exemplo:

Digamos que existe uma transação com o status `created` a 5 minutos no banco de dados. Isso significa que essa transação não foi completa por algum motivo.
Neste caso, poderiamos criar algumas tarefas agendadas para reprocessar essa transferência ou até mesmo rejeitar caso passe algum tempo específico e a transação não foi completa.

Outro possível problema seria uma transação ser completada, mas a notificação não ser enviada. Nessa caso, poderiamos ter uma tarefa para reenviar essas notificação para transações com
status `succeeded` e com `notified_at = null`.

## Como rodar o sistema

Requisitos básicos:
- Docker
- Git

1. Clone o projeto
```sh
git clone git@github.com:PedroPMS/money-transaction.git && cd money-transaction
```

2. Execute os containers via make file
```sh
make build
```

3. Copie o .env
```sh
cp .env.example .env
```

4. Rode as migrations:
```sh
make migrate
```

5. Pronto! O sistema já está pronto para receber requisições.

## Endpoints

Após rodar o projeto, os endpoint podem ser encontrados em:

http://localhost:88/docs/

## O que pode ser melhorado

Como se trata de um sistema crítico, seria muito interessante ter logs de tudo o que acontece relacionado as transações.
Um abordagem interessante para isso é fazer o sistema _Event Driven_, dessa forma armazenando todos os eventos para termos um histórico
de tudo o que acontece com uma transação. Assim, poderiamos por exmplo ter mais pontos de ação para refazer um fluxo ou tomar uma decisão diferente, 
da mesma maneira que acontece hoje com as transações `rejected` e `succeeded`.

*Obs: tentando implementar essas melhorias de arquitetura, fiz um novo repositório utilizando os estudo que havia feito sobre Event Driven*

https://github.com/PedroPMS/picpay
