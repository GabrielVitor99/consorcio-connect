<?php
// Conexão com o banco de dados
require "conexaoBanco.php";

$nome = strip_tags($_POST['nome']);
$matricula = strip_tags($_POST['matricula']);
$cargo = strip_tags($_POST['cargo_funcionario']);
$telefone = strip_tags($_POST['telefone']);

    // Verificar se uma das caixas está vazia
    $requiredFields = array('nome', 'matricula', 'cargo_funcionario', 'telefone');
    $missingFields = array();

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        $missingFieldsList = implode(', ', $missingFields);
        echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
    } else{
            // Verificar se já existem os mesmos dados cadastrados
            $sql_verificar = $pdo->prepare("SELECT COUNT(*) FROM `funcionarios` WHERE nome = ? OR matricula = ?");
            $sql_verificar->execute(array($nome, $matricula));
            // Ele soma os nomes e/ou matrículas do mesmo que já estão cadastradas
            $erro = $sql_verificar->fetchColumn();

            if ($erro > 0) {
                echo '<script>alert("Já existe um funcionário cadastrado com o mesmo nome e/ou matrícula.")</script>';
            }
            else {
                // Restante do código para inserir no banco de dados
                $sql = $pdo->prepare("INSERT INTO `funcionarios` (nome, matricula, cargo_id, telefone) 
                VALUES (?, ?, ?, ?)");

                if ($sql->execute(array($nome, $matricula, $cargo, $telefone))) {
                    echo '<script>alert("Funcionário cadastrado com sucesso!")</script>';
                } else {
                    die("Falhou");
                }
  
            }
        }
?>