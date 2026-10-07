```Mermaid
---
title: Sistema VetCare LR
---
erDiagram
    TUTORES {
        int ID PK 
        varchar nome 
        varchar cpf
        varchar telefone
        varchar senha  
    }

    PACIENTES {
        int ID PK
        varchar nome
        varchar tipo_animal
        int id_tutor FK
    }

    AGENDAMENTOS {
        int ID PK
        int id_tutor FK
        int id_paciente FK
        varchar tipo_atendimento
        date data
        time horario
        varchar observacoes
        varchar status
    }

    FUNCIONARIOS {
        int ID PK 
        varchar nome
        varchar email
        varchar telefone
        varchar senha 
    }

    CONFIGURACOES {
        int ID PK 
        varchar horario_atendimento
        varchar localizacao
        varchar telefone
        varchar email
    }

TUTORES ||--O{ PACIENTES : possuem
TUTORES ||--O{ AGENDAMENTOS : solicitam
PACIENTES ||--O{ AGENDAMENTOS : tem
```