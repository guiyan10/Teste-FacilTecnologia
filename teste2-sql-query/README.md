# Teste 2 - Consulta SQL Agrupada

## Objetivo
Construir uma consulta SQL que liste uma relação com resultado agrupado por nome do banco e por verba, contendo:
- Nome de cada banco (agrupado)
- Verba (agrupado)
- Data de inclusão do contrato mais antigo deste agrupamento
- Data de inclusão do contrato mais novo deste agrupamento
- Soma do valor dos contratos neste agrupamento

## Arquivos

### `consulta_agrupada.sql`
Consulta SQL pura que pode ser executada diretamente no MySQL.

### `consulta_agrupada.php`
Script PHP que executa a consulta SQL agrupada e apresenta os resultados em formato HTML com estilização.

## Como Executar

### SQL Direto
```bash
mysql -u root -p sistema_contratos < consulta_agrupada.sql
```

### Via Script PHP
1. Via servidor web: `http://localhost/teste2-sql-query/consulta_agrupada.php`
2. Via linha de comando: `php consulta_agrupada.php`

## Consulta SQL Utilizada

```sql
SELECT 
    b.nome AS nome_banco,
    c.verba,
    MIN(ct.data_inclusao) AS data_contrato_mais_antigo,
    MAX(ct.data_inclusao) AS data_contrato_mais_novo,
    SUM(ct.valor) AS soma_valor_contratos,
    COUNT(ct.codigo) AS quantidade_contratos
FROM Tb_contrato ct
INNER JOIN Tb_convenio_servico cs ON ct.convenio_servico = cs.codigo
INNER JOIN Tb_convenio c ON cs.convenio = c.codigo
INNER JOIN Tb_banco b ON c.banco = b.codigo
GROUP BY b.nome, c.verba
ORDER BY b.nome, c.verba;
```

## Funções de Agregação Utilizadas

- `MIN(ct.data_inclusao)` - Encontra a data mais antiga
- `MAX(ct.data_inclusao)` - Encontra a data mais nova
- `SUM(ct.valor)` - Soma todos os valores dos contratos
- `COUNT(ct.codigo)` - Conta a quantidade de contratos (campo adicional)

## Agrupamento

A consulta agrupa os resultados por:
1. `b.nome` (Nome do banco)
2. `c.verba` (Verba)

Isso significa que cada linha do resultado representa um grupo único de banco + verba, com as estatísticas agregadas dos contratos pertencentes a esse grupo.

## Resultado Esperado

A consulta retorna um resumo estatístico dos contratos agrupados por banco e verba, mostrando:
- Informações do agrupamento (banco e verba)
- Período dos contratos (data mais antiga e mais nova)
- Valor total dos contratos no agrupamento
- Quantidade de contratos no agrupamento
