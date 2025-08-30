# Testes FacilTecnologia - Sistema de Contratos

Este projeto contém as soluções para os testes técnicos da FacilTecnologia, organizados em diretórios separados conforme solicitado.

## Estrutura do Projeto

```
├── teste1-php-script/          # Teste 1 - Script PHP para listagem de contratos
├── teste2-sql-query/           # Teste 2 - Consulta SQL agrupada
├── database/                   # Scripts de criação das tabelas
├── config/                     # Configurações do banco de dados
└── README.md                   # Este arquivo
```

## Teste 1 - Script PHP para Listagem de Contratos

**Localização:** `teste1-php-script/`

**Objetivo:** Criar um script PHP que execute uma consulta e liste uma relação contendo:
- Nome do banco
- Verba
- Código do contrato
- Data de inclusão
- Valor
- Prazo

**Arquivos:**
- `consulta_contratos.php` - Versão básica do script
- `consulta_contratos_v2.php` - Versão melhorada com estilização e configuração centralizada

## Teste 2 - Consulta SQL Agrupada

**Localização:** `teste2-sql-query/`

**Objetivo:** Criar uma consulta SQL agrupada por nome do banco e verba, listando:
- Nome de cada banco (agrupado)
- Verba (agrupado)
- Data de inclusão do contrato mais antigo do agrupamento
- Data de inclusão do contrato mais novo do agrupamento
- Soma do valor dos contratos no agrupamento

**Arquivos:**
- `consulta_agrupada.sql` - Consulta SQL pura
- `consulta_agrupada.php` - Script PHP que executa a consulta agrupada

## Estrutura das Tabelas

### Relacionamentos
- `Tb_contrato.convenio_servico` → `Tb_convenio_servico.codigo`
- `Tb_convenio_servico.convenio` → `Tb_convenio.codigo`
- `Tb_convenio.banco` → `Tb_banco.codigo`

### Diagrama de Relacionamentos
```
Tb_banco (1) ←→ (N) Tb_convenio (1) ←→ (N) Tb_convenio_servico (1) ←→ (N) Tb_contrato
```

## Configuração e Execução

### Pré-requisitos
- PHP 7.4 ou superior
- MySQL 5.7 ou superior
- Servidor web (Apache/Nginx) ou PHP built-in server

### Configuração do Banco de Dados

1. Execute o script de criação das tabelas:
```sql
mysql -u root -p < database/create_tables.sql
```

2. Ajuste as configurações de conexão em `config/database_config.php` se necessário.

### Executando os Scripts

#### Teste 1 - Script PHP
```bash
# Via servidor web
http://localhost/teste1-php-script/consulta_contratos_v2.php

# Via linha de comando
php teste1-php-script/consulta_contratos_v2.php
```

#### Teste 2 - Consulta SQL
```bash
# Executar SQL diretamente
mysql -u root -p sistema_contratos < teste2-sql-query/consulta_agrupada.sql

# Via script PHP
http://localhost/teste2-sql-query/consulta_agrupada.php
```

## Observações Técnicas

### Relacionamentos entre Tabelas
Conforme especificado no teste, quando um campo é utilizado para ligar uma tabela a outra, este campo tem como nome o nome da segunda tabela:
- `convenio_servico` em `Tb_contrato` referencia `Tb_convenio_servico`
- `convenio` em `Tb_convenio_servico` referencia `Tb_convenio`
- `banco` em `Tb_convenio` referencia `Tb_banco`

### Consultas Implementadas

**Teste 1:** JOIN simples entre todas as tabelas para listar os dados relacionados.

**Teste 2:** Consulta com agrupamento usando:
- `GROUP BY` para agrupar por banco e verba
- `MIN()` para encontrar a data mais antiga
- `MAX()` para encontrar a data mais nova
- `SUM()` para somar os valores dos contratos

## Autor
Desenvolvido para os testes técnicos da FacilTecnologia.
