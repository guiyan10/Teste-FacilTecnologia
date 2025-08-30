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
            max-width: 1400px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
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
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
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
            color: #e74c3c;
            font-family: 'Courier New', monospace;
        }
        .banco {
            background: #fff3cd;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: bold;
            color: #856404;
            display: inline-block;
        }
        .verba {
            background: #d1ecf1;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: 600;
            color: #0c5460;
            display: inline-block;
        }
        .data {
            color: #6c757d;
            font-weight: 500;
            text-align: center;
        }
        .quantidade {
            background: #e2e3e5;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.9em;
            font-weight: 600;
            color: #383d41;
            text-align: center;
        }
        .summary {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .summary-item {
            text-align: center;
        }
        .summary-value {
            font-size: 1.8em;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .summary-label {
            opacity: 0.9;
            font-size: 0.9em;
        }
        @media (max-width: 768px) {
            .container { margin: 10px; }
            .header { padding: 20px; }
            .content { padding: 20px; }
            th, td { padding: 10px 8px; font-size: 0.9em; }
            .summary { flex-direction: column; gap: 15px; }
        }
    </style>\n";
    
    // Exibe os resultados com layout moderno
    echo "<div class='container'>\n";
    echo "<div class='header'>\n";
    echo "<h1>📈 Relatório Agrupado de Contratos</h1>\n";
    echo "<p>Análise por Banco e Verba - FacilTecnologia | Teste 2</p>\n";
    echo "</div>\n";
    echo "<div class='content'>\n";
    
    echo "<table>\n";
    echo "<thead>\n";
    echo "<tr>\n";
    echo "<th>🏦 Banco</th>\n";
    echo "<th>💰 Verba</th>\n";
    echo "<th>📅 Data Mais Antiga</th>\n";
    echo "<th>📅 Data Mais Nova</th>\n";
    echo "<th>💵 Soma dos Valores</th>\n";
    echo "<th>📊 Qtd. Contratos</th>\n";
    echo "</tr>\n";
    echo "</thead>\n";
    echo "<tbody>\n";
    
    $totalGeral = 0;
    $totalContratos = 0;
    
    if (count($resultados) > 0) {
        foreach ($resultados as $row) {
            $totalGeral += $row['soma_valor_contratos'];
            $totalContratos += $row['quantidade_contratos'];
            
            echo "<tr>\n";
            echo "<td class='banco'>" . htmlspecialchars($row['nome_banco']) . "</td>\n";
            echo "<td class='verba'>" . htmlspecialchars($row['verba']) . "</td>\n";
            echo "<td class='data'>" . date('d/m/Y', strtotime($row['data_contrato_mais_antigo'])) . "</td>\n";
            echo "<td class='data'>" . date('d/m/Y', strtotime($row['data_contrato_mais_novo'])) . "</td>\n";
            echo "<td class='valor'>R$ " . number_format($row['soma_valor_contratos'], 2, ',', '.') . "</td>\n";
            echo "<td class='quantidade'>" . htmlspecialchars($row['quantidade_contratos']) . "</td>\n";
            echo "</tr>\n";
        }
    } else {
        echo "<tr><td colspan='6' style='text-align: center; padding: 40px; color: #6c757d;'>📄 Nenhum agrupamento encontrado</td></tr>\n";
    }
    
    echo "</tbody>\n";
    echo "</table>\n";
    
    echo "<div class='summary'>\n";
    echo "<div class='summary-item'>\n";
    echo "<div class='summary-value'>" . count($resultados) . "</div>\n";
    echo "<div class='summary-label'>📊 Agrupamentos</div>\n";
    echo "</div>\n";
    echo "<div class='summary-item'>\n";
    echo "<div class='summary-value'>R$ " . number_format($totalGeral, 0, ',', '.') . "</div>\n";
    echo "<div class='summary-label'>💰 Valor Total Geral</div>\n";
    echo "</div>\n";
    echo "<div class='summary-item'>\n";
    echo "<div class='summary-value'>" . $totalContratos . "</div>\n";
    echo "<div class='summary-label'>📋 Total de Contratos</div>\n";
    echo "</div>\n";
    echo "<div class='summary-item'>\n";
    echo "<div class='summary-value'>R$ " . number_format($totalGeral / max($totalContratos, 1), 0, ',', '.') . "</div>\n";
    echo "<div class='summary-label'>📈 Valor Médio por Contrato</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    echo "</div>\n";
    
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
