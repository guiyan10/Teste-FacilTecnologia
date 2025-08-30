<?php
/**
 * Script PHP para consulta de contratos com dados relacionados (Versão 2)
 * Teste 1 - FacilTecnologia
 * 
 * Este script executa uma consulta que lista:
 * - Nome do banco
 * - Verba
 * - Código do contrato
 * - Data de inclusão
 * - Valor
 * - Prazo
 */

// Inclui a configuração do banco de dados
require_once '../config/database_config.php';

try {
    // Obtém a conexão com o banco de dados
    $pdo = DatabaseConfig::getConnection();
    
    // Query SQL com JOINs para buscar os dados relacionados
    $sql = "
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
    ";
    
    // Executa a consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // CSS para estilização da tabela
    echo "<style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .valor { text-align: right; }
        .total { font-weight: bold; color: #2c5aa0; }
    </style>\n";
    
    // Exibe os resultados
    echo "<h1>Relatório de Contratos - Teste 1</h1>\n";
    echo "<p><em>Listagem de todos os contratos com informações relacionadas</em></p>\n";
    
    echo "<table>\n";
    echo "<thead>\n";
    echo "<tr>\n";
    echo "<th>Nome do Banco</th>\n";
    echo "<th>Verba</th>\n";
    echo "<th>Código do Contrato</th>\n";
    echo "<th>Data de Inclusão</th>\n";
    echo "<th>Valor</th>\n";
    echo "<th>Prazo (meses)</th>\n";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    $totalValor = 0;
    
    if (count($resultados) > 0) {
        foreach ($resultados as $row) {
            $totalValor += $row['valor'];
            echo "<tr>\n";
            echo "<td>" . htmlspecialchars($row['nome_banco']) . "</td>\n";
            echo "<td>" . htmlspecialchars($row['verba']) . "</td>\n";
            echo "<td>" . htmlspecialchars($row['codigo_contrato']) . "</td>\n";
            echo "<td>" . date('d/m/Y', strtotime($row['data_inclusao'])) . "</td>\n";
            echo "<td class='valor'>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['prazo']) . " meses</td>\n";
            echo "</tr>\n";
        }
    } else {
        echo "<tr><td colspan='6'>Nenhum contrato encontrado</td></tr>\n";
    }
    
    echo "</tbody>\n";
    echo "</table>\n";
    
    echo "<div class='total'>\n";
    echo "<p><strong>Total de contratos encontrados:</strong> " . count($resultados) . "</p>\n";
    echo "<p><strong>Valor total dos contratos:</strong> R$ " . number_format($totalValor, 2, ',', '.') . "</p>\n";
    echo "</div>\n";
    
} catch (Exception $e) {
    echo "<h2>Erro:</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
