# VetCare LR — Sistema de Gestão Veterinária

O VetCare LR é uma aplicação web desenvolvida em PHP com PostgreSQL, criada como projeto do curso técnico em Desenvolvimento de Sistemas do SENAI. O sistema tem como objetivo facilitar a organização e o gerenciamento de uma clínica veterinária, reunindo funcionalidades para cadastro de tutores, cadastro de pacientes e gerenciamento de agendamentos.

A aplicação foi planejada para atender diferentes tipos de animais, desde pequenos animais até animais de grande porte, especialmente bovinos e equinos. Dessa forma, o sistema considera as necessidades de uma clínica veterinária que também realiza atendimentos relacionados ao meio rural.

O projeto conta com uma página inicial para apresentação da clínica, uma página de serviços e uma área administrativa para auxiliar no gerenciamento das informações. O banco de dados PostgreSQL é utilizado para armazenar os registros, enquanto o PHP realiza o processamento das informações e a comunicação com o banco.

## 1. Tecnologias utilizadas

- **PHP:** processamento das informações e funcionalidades do sistema.
- **PostgreSQL:** armazenamento e gerenciamento dos dados.
- **HTML:** estrutura das páginas.
- **CSS:** estilização e organização visual.
- **JavaScript:** recursos complementares da interface.
- **PDO:** conexão entre o PHP e o PostgreSQL.
- **Git e GitHub:** controle de versão e armazenamento do código-fonte.
- **Apache:** disponibilização da aplicação em um servidor web Linux.
- **MobaXterm:** acesso remoto ao servidor por SSH.

## 2. Funcionalidades do sistema

### 2.1 Área pública

- Apresentação da clínica veterinária na página inicial.
- Visualização dos serviços oferecidos.
- Consulta das informações disponíveis no site.
- Acesso à página de agendamentos antes de realizar o login.
- Solicitação de agendamento mediante autenticação do tutor.

### 2.2 Cadastro de tutores e pacientes

- Cadastro de tutores.
- Consulta dos dados dos tutores cadastrados.
- Cadastro de pacientes vinculados aos seus respectivos tutores.
- Identificação do tipo de animal atendido.
- Organização dos registros no banco de dados.

### 2.3 Gerenciamento de agendamentos

- Solicitação de agendamentos.
- Consulta dos agendamentos registrados.
- Identificação do tutor e do paciente relacionados à solicitação.
- Registro do tipo de atendimento, data, horário e observações.
- Confirmação ou recusa de solicitações pela área administrativa.
- Registro do motivo da recusa de um agendamento.

### 2.4 Área administrativa

- Login administrativo.
- Painel inicial com informações gerais do sistema.
- Contagem dos agendamentos do dia.
- Consulta da quantidade de pacientes cadastrados.
- Consulta da quantidade de funcionários.
- Gerenciamento da equipe administrativa.

## 3. Como executar o projeto no servidor

Para disponibilizar o VetCare LR para acesso pelo navegador, é necessário ter um servidor Linux configurado com PHP, PostgreSQL e um servidor web, como o Apache.

O MobaXterm pode ser utilizado para acessar esse servidor remotamente por SSH. Ele permite executar os comandos de instalação, configuração e atualização dos arquivos do projeto.

### 3.1 Pré-requisitos

- MobaXterm instalado no computador utilizado para administrar o servidor.
- Acesso SSH autorizado ao servidor Linux.
- Git instalado no servidor.
- PHP compatível com o projeto.
- Extensão `pdo_pgsql` habilitada no PHP.
- PostgreSQL instalado e em execução.
- Apache instalado e configurado.
- Acesso administrativo para configurar os serviços e o banco de dados.
- IP público ou domínio configurado para acesso externo, caso o sistema precise ser acessado pela internet.

### Passo 1: Acessar o servidor pelo MobaXterm

Abra o MobaXterm e crie uma sessão SSH utilizando o endereço do servidor, a porta e as credenciais fornecidas pelo administrador.

Após estabelecer a conexão, os comandos deste tutorial devem ser executados no terminal remoto do servidor Linux.

### Passo 2: Instalar os programas necessários

Em servidores Ubuntu ou Debian, atualize a lista de pacotes:

```bash
sudo apt update
```

Instale os programas necessários:

```bash
sudo apt install git apache2 postgresql postgresql-client php libapache2-mod-php php-pgsql
```

Confira a versão do PHP:

```bash
php -v
```

Verifique se a extensão necessária para a conexão com o PostgreSQL está habilitada:

```bash
php -m | grep -i pdo_pgsql
```

O resultado deve apresentar `pdo_pgsql`.

Inicie os serviços:

```bash
sudo systemctl enable --now apache2
sudo systemctl enable --now postgresql
```

### Passo 3: Clonar o repositório

Acesse a pasta utilizada pelo Apache para armazenar os arquivos dos sites:

```bash
cd /var/www/html
```

Clone o repositório:

```bash
sudo git clone https://github.com/leticia-ribeiro0911/vetcarelr.git
```

Entre na pasta do projeto:

```bash
cd /var/www/html/vetcarelr
```

Se a pasta do projeto já existir no servidor, não execute o comando `git clone` novamente. Nesse caso, entre na pasta existente e verifique se os arquivos estão atualizados.

### Passo 4: Configurar o banco de dados

O banco utilizado pelo projeto chama-se `carevetlr`. O arquivo `banco.sql` está localizado na pasta principal do repositório.

Antes de importar os dados, verifique se o banco e as tabelas já existem. Não apague um banco que contenha informações importantes.

Para uma instalação nova, acesse o PostgreSQL:

```bash
sudo -u postgres psql
```

Crie o usuário utilizado pela aplicação:

```sql
CREATE ROLE vetcarelr WITH LOGIN PASSWORD 'SUA_SENHA';
```

Substitua `SUA_SENHA` por uma senha definida para o ambiente.

Crie o banco de dados:

```sql
CREATE DATABASE carevetlr OWNER vetcarelr;
```

Saia do terminal do PostgreSQL:

```text
\q
```

Importe o arquivo SQL:

```bash
sudo -u postgres psql -d carevetlr -f /var/www/html/vetcarelr/banco.sql
```

Aguarde a conclusão da importação. Caso apareçam erros, verifique as mensagens antes de continuar.

**Importante:** os comandos de criação são destinados a uma instalação nova. Se o usuário ou o banco já existirem, verifique a configuração antes de executar novamente. A importação também pode apresentar conflitos caso as tabelas já estejam criadas.

### Passo 5: Configurar a conexão no PHP

Abra o arquivo de conexão:

```bash
sudo nano /var/www/html/vetcarelr/database/conect.php
```

Confira as configurações de conexão com o PostgreSQL. Os dados precisam corresponder ao banco e ao usuário configurados no passo anterior.

A conexão deve utilizar os seguintes valores:

```php
$host = "localhost";
$dbname = "carevetlr";
$user = "vetcarelr";
$pass = "SUA_SENHA";
```

Substitua `SUA_SENHA` pela senha definida para o usuário `vetcarelr`.

Mantenha o restante do código original do arquivo, incluindo a estrutura de conexão já utilizada pelo projeto.

Para salvar no Nano, pressione `Ctrl + O`, depois `Enter` e, por último, `Ctrl + X`.

### Passo 6: Verificar os serviços

Confira se o Apache está funcionando:

```bash
sudo systemctl status apache2
```

Confira também o PostgreSQL:

```bash
sudo systemctl status postgresql
```

Os serviços devem estar ativos.

Verifique se os arquivos do projeto estão na pasta esperada:

```bash
ls -la /var/www/html/vetcarelr
```

A pasta deve conter o arquivo `index.php` e os demais arquivos e diretórios da aplicação.

### Passo 7: Acessar a aplicação

Depois de configurar o servidor web e o banco de dados, abra o navegador e acesse:

```text
http://IP-OU-DOMINIO-DO-SERVIDOR/vetcarelr/
```

Substitua `IP-OU-DOMINIO-DO-SERVIDOR` pelo endereço real do servidor.

Para que o sistema possa ser acessado de outros computadores pela internet, o servidor precisa estar acessível externamente, com o Apache e as regras de rede configurados corretamente.

O MobaXterm é utilizado para administrar o servidor. Depois que a aplicação estiver disponível, o acesso ao site pode ser feito diretamente pelo navegador.

### Passo 8: Acessar a área administrativa

Na página inicial do VetCare LR, utilize a opção de acesso administrativo para abrir a tela de login.

Informe o e-mail e a senha de uma conta válida cadastrada na tabela `funcionarios`.

As credenciais de demonstração devem corresponder aos dados presentes no banco de dados utilizado no ambiente. Não compartilhe senhas pessoais ou credenciais administrativas no repositório público.

## 4. Especificação de Requisitos de Software (SRS)

### 4.1 Introdução

#### 4.1.1 Escopo do sistema

O VetCare LR tem como escopo auxiliar no gerenciamento de uma clínica veterinária por meio de uma aplicação web. O sistema reúne informações sobre tutores, pacientes, serviços e agendamentos, permitindo organizar os registros e facilitar o trabalho administrativo.

A aplicação considera atendimentos a diferentes tipos de animais, incluindo pequenos animais, bovinos e equinos.

#### 4.1.2 Propósito

O propósito do projeto é desenvolver um sistema que facilite a organização das informações de uma clínica veterinária e permita aplicar na prática os conhecimentos de desenvolvimento web, integração com banco de dados, operações CRUD e controle de acesso.

### 4.2 Funções do sistema

As principais funções previstas no projeto são:

- Apresentar informações da clínica e dos serviços oferecidos.
- Cadastrar tutores.
- Consultar tutores cadastrados.
- Cadastrar pacientes e relacioná-los aos tutores.
- Registrar solicitações de agendamento.
- Consultar os agendamentos.
- Confirmar ou recusar solicitações.
- Registrar o motivo de recusa.
- Permitir o acesso administrativo por login.
- Cadastrar e gerenciar funcionários.
- Apresentar indicadores gerais no painel administrativo.

### 4.3 Características dos usuários

| Tipo de usuário | Descrição |
|---|---|
| Visitante | Pode acessar a página inicial e consultar os serviços públicos. |
| Tutor | Pode solicitar agendamentos e utilizar as funcionalidades disponibilizadas ao seu perfil. |
| Funcionário administrativo | Pode acessar as funcionalidades administrativas permitidas pelo sistema. |
| Administrador | Pode acessar a área administrativa e gerenciar os recursos disponibilizados ao seu perfil. |

### 4.4 Requisitos funcionais

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RF01 | Visualização da página inicial | O sistema deve apresentar informações gerais sobre a clínica veterinária. | Alta |
| RF02 | Consulta de serviços | O sistema deve permitir visualizar os serviços oferecidos. | Alta |
| RF03 | Cadastro de tutores | O sistema deve permitir registrar os dados dos tutores. | Alta |
| RF04 | Consulta de tutores | O sistema deve permitir consultar os tutores cadastrados. | Alta |
| RF05 | Cadastro de pacientes | O sistema deve permitir cadastrar pacientes e vinculá-los aos seus tutores. | Alta |
| RF06 | Solicitação de agendamento | O sistema deve permitir registrar solicitações de atendimento. | Alta |
| RF07 | Consulta de agendamentos | O sistema deve permitir visualizar os agendamentos registrados. | Alta |
| RF08 | Confirmação de agendamentos | O sistema deve permitir confirmar solicitações pela área administrativa. | Alta |
| RF09 | Recusa de agendamentos | O sistema deve permitir recusar solicitações e registrar o motivo. | Alta |
| RF10 | Login administrativo | O sistema deve validar as credenciais de acesso à área administrativa. | Alta |
| RF11 | Cadastro de funcionários | O sistema deve permitir cadastrar funcionários autorizados. | Alta |
| RF12 | Painel administrativo | O sistema deve apresentar informações gerais e contagens do sistema. | Média |

### 4.5 Requisitos não funcionais

| ID | Requisito | Descrição | Prioridade |
|---|---|---|---|
| RNF01 | Tecnologias utilizadas | O sistema deve utilizar PHP no processamento e PostgreSQL no armazenamento dos dados. | Alta |
| RNF02 | Organização do código | Os arquivos devem ser organizados de maneira a separar as funcionalidades e facilitar a manutenção. | Alta |
| RNF03 | Compatibilidade web | A aplicação deve ser acessível por navegadores modernos. | Alta |
| RNF04 | Acesso ao banco de dados | A conexão entre PHP e PostgreSQL deve utilizar PDO e consultas preparadas quando aplicável. | Alta |
| RNF05 | Controle de acesso | As páginas administrativas devem respeitar as regras de autenticação do sistema. | Alta |
| RNF06 | Usabilidade | A interface deve facilitar a navegação e a utilização das funcionalidades. | Média |
| RNF07 | Padronização visual | As páginas devem manter uma identidade visual consistente. | Média |
| RNF08 | Manutenção | A estrutura do projeto deve permitir alterações e correções futuras. | Média |

### 4.6 Regras de negócio

| ID | Regra | Descrição |
|---|---|---|
| RN01 | Vínculo entre tutor e paciente | Cada paciente deve estar relacionado ao tutor correspondente. |
| RN02 | Solicitação de agendamento | O sistema deve registrar as informações necessárias para solicitar um atendimento. |
| RN03 | Controle de status | Os agendamentos devem possuir um status que permita acompanhar a situação da solicitação. |
| RN04 | Confirmação administrativa | As solicitações devem poder ser confirmadas pela área administrativa. |
| RN05 | Recusa com motivo | Ao recusar uma solicitação, o sistema deve permitir registrar o motivo da recusa. |
| RN06 | Acesso administrativo | As funcionalidades administrativas devem exigir autenticação conforme as regras do sistema. |

## 5. Estrutura do banco de dados

O sistema utiliza PostgreSQL para armazenar as informações da aplicação. Entre as principais entidades do projeto estão tutores, pacientes, agendamentos e funcionários, além da tabela utilizada para configurações do sistema.

### 5.1 Tabela `tutores`

Armazena os dados dos tutores cadastrados.

Informações relacionadas incluem:

- Identificador do tutor.
- Nome.
- CPF.
- Telefone.
- Senha de acesso.

### 5.2 Tabela `pacientes`

Armazena os dados dos animais cadastrados.

Informações relacionadas incluem:

- Identificador do paciente.
- Nome.
- Tipo de animal.
- Identificador do tutor responsável.

A relação entre tutores e pacientes permite organizar os animais de acordo com seus responsáveis.

### 5.3 Tabela `agendamentos`

Armazena as solicitações de atendimento.

Informações relacionadas incluem:

- Identificador do agendamento.
- Identificador do tutor.
- Identificador do paciente.
- Tipo de atendimento.
- Data.
- Horário.
- Observações.
- Status.
- Motivo da recusa, quando aplicável.

A tabela permite acompanhar as solicitações e seus respectivos estados.

### 5.4 Tabela `funcionarios`

Armazena os dados dos funcionários que acessam a área administrativa.

Informações relacionadas incluem:

- Identificador do funcionário.
- Nome.
- E-mail.
- Telefone.
- Senha.

O e-mail e a senha são utilizados no login administrativo.

### 5.5 Tabela `configuracoes`

Armazena configurações utilizadas pelo sistema, conforme a estrutura definida no banco de dados do projeto.

**Observação:** para consultar os tipos de dados, as chaves primárias, as chaves estrangeiras e as restrições exatas de cada tabela, consulte o arquivo `banco.sql`.

## 6. Organização dos arquivos

A estrutura principal do projeto está organizada da seguinte maneira:

```text
vetcarelr/
├── admin/
├── database/
│   └── conect.php
├── elaboracao/
├── imagens/
├── includes/
│   ├── admfooter.php
│   ├── admheader.php
│   ├── footer.php
│   ├── functions.php
│   └── header.php
├── login/
├── videos/
├── css/
├── agendamentos.php
├── banco.sql
├── index.php
└── servicos.php
```

Essa estrutura apresenta os principais arquivos e diretórios utilizados no projeto. Outros arquivos podem existir dentro das pastas, de acordo com as funcionalidades implementadas.

## 7. Diagramas e protótipos

Os diagramas e protótipos utilizados no planejamento do VetCare LR podem ser adicionados a esta seção para facilitar a compreensão da estrutura do sistema.

### 7.1 Protótipo de interface

O protótipo apresenta a organização visual planejada para as páginas públicas e administrativas.

### 7.2 Diagrama entidade-relacionamento

O diagrama entidade-relacionamento representa as tabelas do banco de dados e os relacionamentos entre tutores, pacientes, agendamentos e funcionários.

### 7.3 Diagrama de casos de uso

O diagrama de casos de uso representa as interações dos visitantes, tutores e funcionários com as funcionalidades do sistema.

### 7.4 Fluxo de agendamento

O fluxograma representa as etapas de solicitação, análise, confirmação ou recusa de um agendamento.

> Os diagramas devem ser inseridos nesta seção utilizando os caminhos reais dos arquivos de imagem ou documentos disponíveis no repositório.

## 8. Considerações finais

O VetCare LR foi desenvolvido como projeto acadêmico para aplicar os conhecimentos adquiridos no curso técnico em Desenvolvimento de Sistemas. O projeto reúne conceitos de programação em PHP, banco de dados PostgreSQL, desenvolvimento de interfaces web e organização de funcionalidades administrativas.

A proposta é facilitar o gerenciamento de uma clínica veterinária e oferecer uma estrutura que possa receber melhorias e novas funcionalidades ao longo do desenvolvimento.

## Autoria

**Desenvolvido por Letícia Ribeiro**  
Projeto do curso técnico em Desenvolvimento de Sistemas — SENAI.

© 2026 VetCare LR. Todos os direitos reservados.
