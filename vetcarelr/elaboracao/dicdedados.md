
# Dicionário de Dados - VetCare LR

## 1. Tabela TUTORES

Guarda as informações dos tutores cadastrados no sistema.

| Campo | Tipo | Descrição |
|---|---|---|
| id | INT | Código do tutor (PK). |
| nome | VARCHAR | Nome do tutor. |
| cpf | VARCHAR | CPF do tutor. |
| telefone | VARCHAR | Telefone do tutor. |
| senha | VARCHAR | Senha de acesso. |

## 2. Tabela PACIENTES

Guarda as informações dos animais cadastrados.

| Campo | Tipo | Descrição |
|---|---|---|
| id | INT | Código do animal (PK). |
| nome | VARCHAR | Nome do animal. |
| tipo_animal | VARCHAR | Tipo do animal. |
| id_tutor | INT | Código do tutor responsável (FK). |

## 3. Tabela AGENDAMENTOS

Guarda as informações dos atendimentos agendados.

| Campo | Tipo | Descrição |
|---|---|---|
| id | INT | Código do agendamento (PK). |
| id_tutor | INT | Código do tutor (FK). |
| id_paciente | INT | Código do animal (FK). |
| tipo_atendimento | VARCHAR | Tipo de atendimento. |
| data | DATE | Data do atendimento. |
| horario | TIME | Horário do atendimento. |
| observacoes | VARCHAR | Observações sobre o atendimento. |
| status | VARCHAR | Situação do agendamento. |

## 4. Tabela FUNCIONARIOS

Guarda os dados dos funcionários do hospital.

| Campo | Tipo | Descrição |
|---|---|---|
| id | INT | Código do funcionário (PK). |
| nome | VARCHAR | Nome do funcionário. |
| email | VARCHAR | E-mail do funcionário. |
| telefone | VARCHAR | Telefone do funcionário. |
| senha | VARCHAR | Senha de acesso. |

## Legenda

- PK: chave primária.
- FK: chave estrangeira.
- INT: número inteiro.
- VARCHAR: texto.
- DATE: data.
- TIME: horário.