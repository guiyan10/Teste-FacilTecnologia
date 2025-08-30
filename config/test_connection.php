<?php
/**
 * Script para testar a conexão com o banco de dados
 * FacilTecnologia - Testes
 */

require_once 'database_config.php';

echo "<h1>Teste de Conexão com o Banco de Dados</h1>\n";

try {
    $pdo = DatabaseConfig::getConnection();
    echo "<p style='color: green;'><strong>✓ Conexão estabelecida com sucesso!</strong></p>\n";
    
    // Testa se as tabelas existem
    $tables = ['Tb_banco', 'Tb_convenio', 'Tb_convenio_servico', 'Tb_contrato'];
    
    echo "<h2>Verificação das Tabelas:</h2>\n";
    echo "<ul>\n";
    
    foreach ($tables as $table) {
        try {
            $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
            $count = $stmt->fetchColumn();
            echo "<li style='color: green;'>✓ Tabela <strong>$table</strong> existe e contém $count registros</li>\n";
        } catch (PDOException $e) {
            echo "<li style='color: red;'>✗ Tabela <strong>$table</strong> não encontrada ou erro: " . $e->getMessage() . "</li>\n";
        }
    }
    
    echo "</ul>\n";
    
} catch (Exception $e) {
    echo "<p style='color: red;'><strong>✗ Erro na conexão:</strong> " . $e->getMessage() . "</p>\n";
    echo "<p><strong>Verifique:</strong></p>\n";
    echo "<ul>\n";
    echo "<li>Se o MySQL está rodando</li>\n";
    echo "<li>Se o banco 'sistema_contratos' foi criado</li>\n";
    echo "<li>Se as credenciais em database_config.php estão corretas</li>\n";
    echo "</ul>\n";
}
?>
