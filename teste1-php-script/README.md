# Teste 1 - Script PHP para Consulta de Contratos

## Objetivo
Construir um script PHP que execute uma consulta e liste uma relação contendo:
- Nome do banco
- Verba
- Código do contrato
- Data de inclusão
- Valor
- Prazo

## Arquivos

### `consulta_contratos.php`
Versão básica do script com conexão direta ao banco de dados.

### `consulta_contratos_v2.php` (Recomendado)
Versão melhorada que utiliza:
- Configuração centralizada de banco de dados
- Estilização CSS para melhor apresentação
- Tratamento de erros aprimorado
- Formatação de valores monetários
- Formatação de datas

## Como Executar

### Via Servidor Web
1. Certifique-se de que o servidor web está rodando
2. Acesse: `http://localhost/teste1-php-script/consulta_contratos_v2.php`

### Via Linha de Comando
```bash
php consulta_contratos_v2.php
```

## Consulta SQL Utilizada

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
INNER JOIN Tb_banco b ON c.banco = b.codigo
ORDER BY b.nome, c.verba, ct.codigo
```

## Relacionamentos das Tabelas

A consulta utiliza os seguintes JOINs:
1. `Tb_contrato` → `Tb_convenio_servico` (via campo `convenio_servico`)
2. `Tb_convenio_servico` → `Tb_convenio` (via campo `convenio`)
3. `Tb_convenio` → `Tb_banco` (via campo `banco`)

## Resultado Esperado

A consulta retorna uma listagem com todos os contratos e suas informações relacionadas, ordenados por nome do banco, verba e código do contrato.
