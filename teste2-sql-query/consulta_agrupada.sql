-- Consulta SQL para agrupamento de contratos por banco e verba
-- Teste 2 - FacilTecnologia
--
-- Esta consulta lista:
-- - Nome de cada banco (agrupado)
-- - Verba (agrupado)
-- - Data de inclusão do contrato mais antigo do agrupamento
-- - Data de inclusão do contrato mais novo do agrupamento
-- - Soma do valor dos contratos no agrupamento

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
