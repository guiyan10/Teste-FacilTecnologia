# Diagrama de Relacionamentos - Sistema de Contratos

## Estrutura das Tabelas

### Tb_banco
- `codigo` (PK, INT, AUTO_INCREMENT)
- `nome` (VARCHAR(100), NOT NULL)

### Tb_convenio
- `codigo` (PK, INT, AUTO_INCREMENT)
- `convenio` (VARCHAR(100), NOT NULL)
- `verba` (VARCHAR(100), NOT NULL)
- `banco` (FK → Tb_banco.codigo)

### Tb_convenio_servico
- `codigo` (PK, INT, AUTO_INCREMENT)
- `convenio` (FK → Tb_convenio.codigo)
- `servico` (VARCHAR(100), NOT NULL)

### Tb_contrato
- `codigo` (PK, INT, AUTO_INCREMENT)
- `prazo` (INT, NOT NULL)
- `valor` (DECIMAL(15,2), NOT NULL)
- `data_inclusao` (DATE, NOT NULL)
- `convenio_servico` (FK → Tb_convenio_servico.codigo)

## Relacionamentos

```
Tb_banco (1:N) Tb_convenio (1:N) Tb_convenio_servico (1:N) Tb_contrato
```

### Explicação dos Relacionamentos

1. **Tb_banco → Tb_convenio**
   - Um banco pode ter vários convênios
   - Campo de ligação: `Tb_convenio.banco`

2. **Tb_convenio → Tb_convenio_servico**
   - Um convênio pode ter vários serviços
   - Campo de ligação: `Tb_convenio_servico.convenio`

3. **Tb_convenio_servico → Tb_contrato**
   - Um convênio_serviço pode ter vários contratos
   - Campo de ligação: `Tb_contrato.convenio_servico`

## Fluxo de Dados

Para obter informações completas de um contrato, é necessário percorrer:
1. `Tb_contrato` (dados do contrato)
2. `Tb_convenio_servico` (serviço relacionado)
3. `Tb_convenio` (convênio e verba)
4. `Tb_banco` (nome do banco)

## Consultas de Exemplo

### Listar todos os contratos com informações relacionadas (Teste 1)
```sql
SELECT 
    b.nome AS nome_banco,
    c.verba,
    ct.codigo AS codigo_contrato,
    ct.data_inclusao,
    ct.valor,
    ct.prazo
FROM Tb_contrato ct
INNER JOIN Tb_convenio_servico cs ON ct.convenio_servico = cs.codigo
INNER JOIN Tb_convenio c ON cs.convenio = c.codigo
INNER JOIN Tb_banco b ON c.banco = b.codigo;
```

### Agrupar contratos por banco e verba (Teste 2)
```sql
SELECT 
    b.nome AS nome_banco,
    c.verba,
    MIN(ct.data_inclusao) AS data_mais_antiga,
    MAX(ct.data_inclusao) AS data_mais_nova,
    SUM(ct.valor) AS soma_valores
FROM Tb_contrato ct
INNER JOIN Tb_convenio_servico cs ON ct.convenio_servico = cs.codigo
INNER JOIN Tb_convenio c ON cs.convenio = c.codigo
INNER JOIN Tb_banco b ON c.banco = b.codigo
GROUP BY b.nome, c.verba;
```
