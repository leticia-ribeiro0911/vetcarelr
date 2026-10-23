# VetCare LR - Sistema de Gestão Veterinária 

Sistema web de gestão veterinária desenvolvido como Projeto Integrador do curso Técnico em Desenvolvimento de Sistemas do SENAI.

## Sobre o projeto

O VetCare LR é um sistema de gestão veterinária desenvolvido com o objetivo de auxiliar na organização do dia a dia de um hospital veterinário.

A proposta é reunir informações importantes para a rotina de atendimento, facilitando o acompanhamento dos pacientes, a organização dos agendamentos e o gerenciamento de dados relacionados aos tutores e aos funcionários.

O sistema considera diferentes tipos de animais, incluindo animais de grande porte, como bovinos e equinos.

O projeto foi desenvolvido utilizando PHP e PostgreSQL, colocando em prática os conhecimentos adquiridos durante o curso Técnico em Desenvolvimento de Sistemas.

## Objetivo

Desenvolver um sistema web que ajude a organizar as atividades administrativas de um hospital veterinário, facilitando o acesso às informações e contribuindo para uma rotina de atendimento mais organizada.

## Instalação e execução

Para executar o VetCare LR, é necessário ter acesso a um servidor preparado para executar aplicações PHP e utilizar um banco de dados PostgreSQL. A extensão PDO também precisa estar habilitada no PHP para permitir a conexão com o banco de dados.

### 1. Clonar o repositório

Acesse o terminal do servidor e entre na pasta em que deseja armazenar o projeto. Em seguida, execute:

```bash
git clone https://github.com/leticia-ribeiro0911/vetcarelr.git
```

Depois, entre na pasta do projeto:

```bash
cd vetcarelr
```

### 2. Criar o banco de dados

O sistema utiliza um banco de dados PostgreSQL chamado `carevetlr`.

Para criá-lo, acesse o PostgreSQL pelo terminal utilizando um usuário que tenha permissão para criar bancos de dados. Em muitos servidores Linux, é possível utilizar o comando:

```bash
sudo -u postgres psql
```

Em seguida, execute:

```sql
CREATE DATABASE carevetlr;
```

Esse comando cria o banco de dados que será utilizado pelo sistema.

Crie o usuário vetcarelr com senha:
```sql
CREATE USER vetcarelr WITH PASSWORD 'lrvetcare';
```

Altere o proprietário do database:
```sql
ALTER DATABASE carevetlr OWNER TO vetcarelr;
```

Para sair do PostgreSQL, execute:

```sql
\q
```

### 3. Criar as tabelas

Localize o arquivo SQL disponibilizado no repositório do projeto. Ele contém os comandos necessários para criar as tabelas do banco de dados.

Execute o arquivo pelo terminal, utilizando o comando abaixo como modelo:

```bash
psql -U postgres -d carevetlr -f caminho/do/arquivo.sql
```

Substitua `caminho/do/arquivo.sql` pelo caminho correto do arquivo no servidor. O usuário informado deve ter permissão para acessar o banco e executar os comandos.

### 4. Configurar a conexão com o banco de dados

Abra o arquivo responsável pela conexão com o banco de dados, localizado na pasta `database`.

Confira e configure as informações de acordo com o ambiente utilizado:

- Nome do banco de dados: `carevetlr`;
- Usuário do PostgreSQL;
- Senha do usuário;
- Endereço do servidor do banco de dados, quando necessário.

Salve as alterações antes de continuar.

### 5. Acessar o sistema

Depois de concluir as etapas anteriores, acesse pelo navegador o endereço disponibilizado pelo servidor para o projeto.

O endereço pode variar conforme a configuração do ambiente. Em um servidor remoto, utilize o endereço IP ou domínio correspondente.

### 6. Acessar a área administrativa

Para acessar a área administrativa, entre na página de login administrativo do sistema.

É necessário possuir uma conta de funcionário previamente cadastrada no banco de dados. Após realizar o login, será possível acessar as funcionalidades administrativas disponíveis.

**Observação:** o MobaXterm pode ser utilizado para acessar um servidor remoto, mas não é obrigatório. Outras ferramentas também podem ser utilizadas, desde que permitam realizar as operações necessárias.

## Tecnologias utilizadas

- **HTML5:** estrutura das páginas.
- **CSS3:** estilização e organização visual.
- **PHP:** funcionamento das páginas e processamento das informações.
- **PostgreSQL:** armazenamento dos dados do sistema.
- **PDO:** conexão entre o PHP e o banco de dados.
- **Bootstrap Icons:** ícones utilizados na interface.
- **Git e GitHub:** versionamento e armazenamento do código-fonte.

## Funcionalidades

### Área pública

- Apresentação do hospital veterinário.
- Exibição dos serviços oferecidos.
- Acesso à página de agendamentos.
- Solicitação de agendamentos para atendimento veterinário.

### Área administrativa

- Acesso por meio de login administrativo.
- Consulta dos agendamentos.
- Confirmação ou recusa de solicitações de atendimento.
- Consulta e gerenciamento das informações dos pacientes.
- Cadastro e gerenciamento de funcionários.
- Consulta das informações utilizadas na rotina administrativa.

## Requisitos de software

Os requisitos funcionais descrevem as ações que o sistema deve permitir realizar, enquanto os requisitos não funcionais apresentam condições relacionadas ao seu funcionamento.

### Requisitos funcionais

- **RF01:** apresentar informações sobre o hospital veterinário.
- **RF02:** exibir os serviços veterinários disponíveis.
- **RF03:** permitir a solicitação de agendamentos.
- **RF04:** armazenar informações dos tutores.
- **RF05:** permitir o cadastro de pacientes e relacioná-los aos seus tutores.
- **RF06:** permitir a consulta dos agendamentos.
- **RF07:** permitir que funcionários autorizados confirmem ou recusem solicitações.
- **RF08:** permitir o acesso à área administrativa por meio de login.
- **RF09:** permitir o cadastro e o gerenciamento de funcionários.

### Requisitos não funcionais

- **RNF01:** o sistema deve ser acessível por meio de um navegador web.
- **RNF02:** as páginas devem apresentar uma organização visual simples e facilitar a navegação.
- **RNF03:** as informações devem ser armazenadas em um banco de dados PostgreSQL.
- **RNF04:** o sistema deve utilizar PHP para processar as informações.
- **RNF05:** o ambiente deve possuir a extensão PDO habilitada para permitir a conexão com o banco de dados.
- **RNF06:** o acesso às funcionalidades administrativas deve ser realizado por meio de autenticação.

## Regras de negócio

- **RN01:** cada paciente deve estar relacionado a um tutor cadastrado.
- **RN02:** um tutor pode possuir mais de um paciente cadastrado.
- **RN03:** os agendamentos devem conter as informações necessárias para identificar o atendimento solicitado.
- **RN04:** os agendamentos podem apresentar os status pendente, confirmado ou recusado.
- **RN05:** a confirmação e a recusa dos agendamentos são realizadas na área administrativa.
- **RN06:** o acesso administrativo depende de um funcionário cadastrado e de suas credenciais de acesso.

## Banco de dados

O VetCare LR utiliza o PostgreSQL para armazenar as informações necessárias para o funcionamento do sistema. No ambiente de desenvolvimento, o banco de dados utilizado possui o nome `carevetlr`.

### Estrutura das tabelas

| Tabela | Finalidade |
|---|---|
| `tutores` | Armazena as informações dos tutores. |
| `pacientes` | Armazena os dados dos animais e sua relação com os tutores. |
| `agendamentos` | Armazena as solicitações e informações dos atendimentos. |
| `funcionarios` | Armazena os dados dos funcionários que acessam a área administrativa. |

Inicialmente, também havia sido considerada uma tabela chamada `configuracoes`, destinada a armazenar informações de configuração do sistema. Durante o desenvolvimento, decidi retirar essa tabela por considerar que essa estrutura não era a alternativa mais viável para a proposta atual do projeto.

### Relacionamentos

- Um tutor pode estar relacionado a vários pacientes.
- Cada paciente pertence a um tutor.
- Os agendamentos relacionam informações do tutor e do paciente atendido.
- Os funcionários possuem seus próprios dados de cadastro e acesso administrativo.

## Estrutura do projeto

```text
vetcarelr/
├── admin/
├── css/
├── database/
├── elaboracao/
├── imagens/
├── includes/
├── login/
├── videos/
├── agendamentos.php
├── index.php
└── servicos.php
```

### Principais arquivos e pastas

- `admin/`: páginas da área administrativa.
- `css/`: arquivos de estilização.
- `database/`: arquivos relacionados à conexão com o banco de dados.
- `elaboracao/`: materiais utilizados durante a elaboração do projeto.
- `imagens/`: imagens utilizadas no sistema.
- `includes/`: arquivos compartilhados entre as páginas.
- `login/`: páginas relacionadas ao acesso de usuários.
- `videos/`: vídeos utilizados na apresentação visual.
- `agendamentos.php`: página de agendamentos.
- `index.php`: página inicial.
- `servicos.php`: página de serviços veterinários.

## Diagramas do projeto

Esta seção pode ser utilizada para apresentar os diagramas elaborados durante o Projeto Integrador, como:

- Diagrama de casos de uso.
- Diagrama entidade-relacionamento (DER).
- Diagrama de atividades, caso tenha sido elaborado.

## Autoria

Projeto desenvolvido por **Letícia Ribeiro da Silva**, como parte do Projeto Integrador do curso Técnico em Desenvolvimento de Sistemas do SENAI.

© 2026 VetCare LR. Todos os direitos reservados.
