<?php
/**
 * Script PHP para consulta agrupada de contratos
 * Teste 2 - FacilTecnologia
 * 
 * Este script executa uma consulta SQL agrupada que lista:
 * - Nome de cada banco (agrupado)
 * - Verba (agrupado)
 * - Data de inclusão do contrato mais antigo do agrupamento
 * - Data de inclusão do contrato mais novo do agrupamento
 * - Soma do valor dos contratos no agrupamento
 */
// Configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = 'sistema_contratos';
$username = 'root';
$password = '';

try {
    // Conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Query SQL com agrupamento por banco e verba
    $sql = "
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
        ORDER BY b.nome, c.verba
    ";
    
    // Executa a consulta
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Exibe os resultados
    echo "<h1>Relatório Agrupado de Contratos por Banco e Verba</h1>\n";
    echo "<table border='1' cellpadding='5' cellspacing='0'>\n";
    echo "<thead>\n";
    echo "<tr>\n";
    echo "<th>Nome do Banco</th>\n";
    echo "<th>Verba</th>\n";
    echo "<th>Data Contrato Mais Antigo</th>\n";
    echo "<th>Data Contrato Mais Novo</th>\n";
    echo "<th>Soma dos Valores</th>\n";
    echo "<th>Quantidade de Contratos</th>\n";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    if (count($resultados) > 0) {
        foreach ($resultados as $row) {
            echo "<tr>\n";
            echo "<td>" . htmlspecialchars($row['nome_banco']) . "</td>\n";
            echo "<td>" . htmlspecialchars($row['verba']) . "</td>\n";
            echo "<td>" . htmlspecialchars($row['data_contrato_mais_antigo']) . "</td>\n";
            echo "<td>" . htmlspecialchars($row['data_contrato_mais_novo']) . "</td>\n";
            echo "<td>R$ " . number_format($row['soma_valor_contratos'], 2, ',', '.') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['quantidade_contratos']) . "</td>\n";
            echo "</tr>\n";
        }
    } else {
        echo "<tr><td colspan='6'>Nenhum dado encontrado</td></tr>\n";
    }
    
    echo "</tbody>\n";
    echo "</table>\n";
    
    echo "<p><strong>Total de agrupamentos:</strong> " . count($resultados) . "</p>\n";
    
} catch (PDOException $e) {
    echo "Erro na conexão ou consulta: " . $e->getMessage();
}

// Versão alternativa para saída em JSON (descomente se necessário)
/*
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'data' => $resultados,
    'total_agrupamentos' => count($resultados)
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
*/
?>
