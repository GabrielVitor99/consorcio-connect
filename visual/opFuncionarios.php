<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulários de Inserção de Dados</title>
    <link rel="stylesheet" href="../estilo/estiloGeral.css">
    <link rel="stylesheet" href="../estilo/estiloJanelas.css">
    <link rel="stylesheet" href="../estilo/estiloLetras.css">
    <link rel="stylesheet" href="../estilo/estiloFormularios.css">
    <link rel="stylesheet" href="../estilo/estiloImagem.css">
    <!-- Inclua a biblioteca jQuery em seu HTML -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="scriptVeiculos.js"></script>
    <!-- Importando arquivos tipo JavaScript -->
    <script src="../JavaScript/janelas.js"></script>
    <script src="../JavaScript/novoFormularios.js"></script>

    <!-- Importando frameworks -->
    <!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

</head>
<body>

<!-- Informações de login (exemplo) -->
<div class="infoContainer" id="infoContainer">
    <p class="infoFuncionario">FUNCIONÁRIO: GABRIEL - SUPERVISOR <br>
        MATRÍCULA: 4325 </p>
    <p class="infoData">DATA: 02/01/2024 <br>
        Hora: 16:13</p>
</div>

<!-- Este header só aparece quando se clica num botão -->
<div id="headerDois">
    <header>
        <h1>Consorcio Connect</h1>
        <a href="home.html" class="icone">Voltar ao início</a>
    </header>
</div>

<!-- Logo -->
<div class="imagem" id="imagemLogo">
    <img src="../imagem/logo.png" alt="Logo">
</div>

<!-- Botões de operação do sistema -->
<main>
    <div class="button-container">
        <a href="opVeiculos.php"><button type="button" id="OpVeiculoBtn">Operações de veículo</button></a>
        <a href="opFuncionarios.php"><button type="button" id="OpFuncionarioBtn">Operações de funcionário</button></a>
        <a href="opEscalas.php"><button type="button" id="OpEscalaBtn">Operações de escala</button></a>
        <a href="opPesquisas.php"><button type="button" id="OpSistemaBuscaBtn" style="background-color: orange;">Sistema de busca - escala</button></a>
    </div>
    
    <!-- Formulário para a tabela "funcionários" -->
    <div class="container">
        <h2>Formulário de Inserção de Funcionários</h2>
        <form action="#" method="POST">
            <label for="nome">Nome do Funcionário:</label>
            <input type="text" id="nome" name="nome">

            <label for="matricula">Matrícula:</label>
            <input type="number" id="matricula" name="matricula">

            <label for="cargo_funcionario">Cargo:</label>
            <select id="cargo_id" name="cargo_funcionario"></select>

            <label for="telefone">Telefone:</label>
            <input type="text" id="telefone" name="telefone">

            <button name='cadastrarFuncionario'>Cadastrar funcionário</button>
        </form>
    </div>

    <div class="container">
        <h2>Operações de banco de dados do funcionário</h2>
        <form action="#" method="POST">
            <select name="tipo_busca">
                <option value="todos">Listar todos os funcionários</option>
                <option value="motoristas">Listar motoristas</option>
                <option value="cobradores">Listar cobradores</option>
            </select>
            <button name="listar">Listar</button>
            <br><br><br>
            <label>Pesquisar por nome: </label>
            <input type="text" id="nomeFuncionario" placeholder="Digite o nome do funcionário">
            <select id="funcionario_id" name="funcionario"></select>
            <br>
            <button name="pesquisarFuncionario">Pesquisar</button>
            <button name="editarFuncionario">Editar</button>
            <button name="excluirFuncionario">Excluir</button>
        </form>
    </div>

</body>
</html>

<?php

require "../includes/conexaoBanco.php";

if (isset($_POST['listar'])) {
    // Verifique se o botão "listar" foi pressionado
    $tipo_busca = $_POST['tipo_busca'];

    // Defina a consulta SQL com base no tipo de busca selecionado
    if ($tipo_busca === 'todos') {
        $sql = $pdo->prepare("SELECT * FROM funcionarios");
    } elseif ($tipo_busca === 'motoristas') {
        $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE cargo_id = 1");
    } elseif ($tipo_busca === 'cobradores') {
        $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE cargo_id = 2");
    }

    $sql->execute();
    $funcionarios = $sql->fetchAll();

    if (count($funcionarios) > 0) {
        // Se houver resultados, exiba-os
        echo "<table>
        <caption> Informações dos funcionários </caption>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Cargo</th>
            <th>Telefone</th>
            <th>Data de cadastro</th>
            <th>Possuí escala</th>
        </tr>";

        foreach ($funcionarios as $funcionario) {
            // Consulta para contar o número de escalas associadas ao veículo
            $sql = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE motorista_id = :funcionario_id or cobrador_id = :funcionario_id");
            $sql->bindParam(':funcionario_id', $funcionario[0]);
            $sql->execute();
            $numEscalas = $sql->fetchColumn();
            if($numEscalas > 0){
                $numEscalas = "SIM";
            } else{
                $numEscalas = "NÃO";
            }

            echo "<tr>";
            echo "<td>" . $funcionario[0] . "</td>";
            echo "<td>" . $funcionario[1] . "</td>";
            echo "<td>" . $funcionario[2] . "</td>";
            echo "<td>" . $funcionario[3] . "</td>";
            echo "<td>" . $funcionario[4] . "</td>";
            echo "<td>" . $funcionario[5] . "</td>";
            echo "<td>" . $numEscalas . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<script>alert('Nenhum veículo encontrado para a opção selecionada.')</script>";
    }
}

if (isset($_POST['pesquisarFuncionario'])) {
    
require "../includes/conexaoBanco.php";
$pesquisar = strip_tags($_POST['funcionario']);

$requiredFields = array('funcionario');
$missingFields = array();

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $missingFields[] = $field;
    }
}

if (!empty($missingFields)) {
    $missingFieldsList = implode(', ', $missingFields);
    echo '<script>alert("Por favor, preencha os seguintes campos: ' . $missingFieldsList . '")</script>';
} else {
    // Consulta para buscar informações do veículo
    $sql = $pdo->prepare("SELECT * FROM funcionarios WHERE id = :pesquisar");
    $sql->bindParam(':pesquisar', $pesquisar);
    $sql->execute();
    $funcionarios = $sql->fetchAll();

    if (count($funcionarios) > 0) {
        echo "<table>
        <caption> Informações do funcionário </caption>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Cargo</th>
            <th>Telefone</th>
            <th>Data de cadastro</th>
            <th>Possuí escala</th>
        </tr>";

        foreach ($funcionarios as $funcionario) {
            // Consulta para contar o número de escalas associadas ao veículo
            $sql = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE motorista_id = :funcionario_id or cobrador_id = :funcionario_id");
            $sql->bindParam(':funcionario_id', $funcionario[0]);
            $sql->execute();
            $numEscalas = $sql->fetchColumn();
            if($numEscalas > 0){
                $numEscalas = "SIM";
            } else{
                $numEscalas = "NÃO";
            }

            echo "<tr>";
            echo "<td>" . $funcionario[0] . "</td>";
            echo "<td>" . $funcionario[1] . "</td>";
            echo "<td>" . $funcionario[2] . "</td>";
            echo "<td>" . $funcionario[3] . "</td>";
            echo "<td>" . $funcionario[4] . "</td>";
            echo "<td>" . $funcionario[5] . "</td>";
            echo "<td>" . $numEscalas . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<script>alert('Erro: não foi encontrado um funcionário com este nome (id)')</script>";
    }
}
}
?>

