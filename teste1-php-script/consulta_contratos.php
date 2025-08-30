<?php
/**
 * Script PHP para consulta de contratos com dados relacionados
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

// Configurações de conexão com o banco de dados
$host = 'localhost';
$dbname = 'sistema_contratos';
$username = 'root';
$password = '';

try {
    // Conexão com o banco de dados usando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
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
    
    // Exibe os resultados
    echo "<h1>Relatório de Contratos</h1>\n";
    echo "<table border='1' cellpadding='5' cellspacing='0'>\n";
    echo "<thead>\n";
    echo "<tr>\n";
    echo "<th>Nome do Banco</th>\n";
    echo "<th>Verba</th>\n";
    echo "<th>Código do Contrato</th>\n";
    echo "<th>Data de Inclusão</th>\n";
    echo "<th>Valor</th>\n";
    echo "<th>Prazo</th>\n";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    if (count($resultados) > 0) {
        foreach ($resultados as $row) {
            echo "<tr>\n";
            echo "<td>" . htmlspecialchars($row['nome_banco']) . "</td>\n";
            echo "<td>" . htmlspecialchars($row['verba']) . "</td>\n";
            echo "<td>" . htmlspecialchars($row['codigo_contrato']) . "</td>\n";
            echo "<td>" . htmlspecialchars($row['data_inclusao']) . "</td>\n";
            echo "<td>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>\n";
            echo "<td>" . htmlspecialchars($row['prazo']) . "</td>\n";
            echo "</tr>\n";
        }
    } else {
        echo "<tr><td colspan='6'>Nenhum contrato encontrado</td></tr>\n";
    }
    
    echo "</tbody>\n";
    echo "</table>\n";
    
    echo "<p><strong>Total de contratos encontrados:</strong> " . count($resultados) . "</p>\n";
    
} catch (PDOException $e) {
    echo "Erro na conexão ou consulta: " . $e->getMessage();
}

// Versão alternativa para saída em JSON (descomente se necessário)
/*
header('Content-Type: application/json');
echo json_encode([
    'status' => 'success',
    'data' => $resultados,
    'total' => count($resultados)
], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
*/
?>
