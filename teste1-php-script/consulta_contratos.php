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
    
    // CSS moderno para estilização da tabela
    echo "<style>
        * { box-sizing: border-box; }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            margin: 0; 
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2.2em;
            font-weight: 300;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1em;
        }
        .content {
            padding: 30px;
        }
        table { 
            border-collapse: collapse; 
            width: 100%; 
            margin-top: 20px;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        th, td { 
            padding: 15px 12px; 
            text-align: left;
            border-bottom: 1px solid #e9ecef;
        }
        th { 
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85em;
            letter-spacing: 0.5px;
        }
        tr:hover { 
            background-color: #f8f9fa;
            transform: scale(1.001);
            transition: all 0.2s ease;
        }
        tr:nth-child(even) { 
            background-color: #fdfdfd; 
        }
        .valor { 
            text-align: right; 
            font-weight: 600;
            color: #28a745;
            font-family: 'Courier New', monospace;
        }
        .codigo {
            background: #e3f2fd;
            padding: 4px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            font-weight: bold;
        }
        .data {
            color: #6c757d;
            font-weight: 500;
        }
        .prazo {
            background: #fff3cd;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            color: #856404;
            text-align: center;
        }
        .stats {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stats-item {
            text-align: center;
        }
        .stats-value {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .stats-label {
            opacity: 0.9;
            font-size: 0.9em;
        }
        @media (max-width: 768px) {
            .container { margin: 10px; }
            .header { padding: 20px; }
            .content { padding: 20px; }
            th, td { padding: 10px 8px; font-size: 0.9em; }
            .stats { flex-direction: column; gap: 15px; }
        }
    </style>\n";
    
    // Exibe os resultados com layout moderno
    echo "<div class='container'>\n";
    echo "<div class='header'>\n";
    echo "<h1>📊 Relatório de Contratos</h1>\n";
    echo "<p>Sistema de Gestão de Contratos - FacilTecnologia | Teste 1 (Versão Básica)</p>\n";
    echo "</div>\n";
    echo "<div class='content'>\n";
    
    echo "<table>\n";
    echo "<thead>\n";
    echo "<tr>\n";
    echo "<th>🏦 Banco</th>\n";
    echo "<th>💰 Verba</th>\n";
    echo "<th>📋 Código</th>\n";
    echo "<th>📅 Data Inclusão</th>\n";
    echo "<th>💵 Valor</th>\n";
    echo "<th>⏱️ Prazo</th>\n";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    $totalValor = 0;
    
    if (count($resultados) > 0) {
        foreach ($resultados as $row) {
            $totalValor += $row['valor'];
            echo "<tr>\n";
            echo "<td><strong>" . htmlspecialchars($row['nome_banco']) . "</strong></td>\n";
            echo "<td>" . htmlspecialchars($row['verba']) . "</td>\n";
            echo "<td class='codigo'>" . htmlspecialchars($row['codigo_contrato']) . "</td>\n";
            echo "<td class='data'>" . date('d/m/Y', strtotime($row['data_inclusao'])) . "</td>\n";
            echo "<td class='valor'>R$ " . number_format($row['valor'], 2, ',', '.') . "</td>\n";
            echo "<td class='prazo'>" . htmlspecialchars($row['prazo']) . " meses</td>\n";
            echo "</tr>\n";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align: center; padding: 40px; color: #6c757d;'>📄 Nenhum contrato encontrado</td></tr>\n";
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
