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


    <!-- Formulário para a tabela "veículos" -->
    <div class="container">
        <h2>Formulário de Inserção de Veículos</h2>
        <form action="#" method="POST">
            <label for="tipo">Tipo de veículo: </label>
            <select id="tipo_id" name="tipo_id"></select>

            <label for="numero">Número:</label>
            <input type="text" id="numero" name="numero">

            <label for="capacidade">Capacidade:</label>
            <input type="number" id="capacidade" name="capacidade">

            <button name='cadastrarVeiculo'>Cadastrar veículo</button>
        </form>
    </div>

    <div class="container">
        <h2>Operações de banco de dados do veículos</h2>
        <form action="#" method="POST">
            <select name="tipo_busca">
              <option value="todos">Listar todos os veículos</option>
               <option value="padrao">Listar padrões</option>
               <option value="executivo">Listar executivos</option>
               <option value="articulado">Listar articulados</option>
            </select>

            <button name="listar">Listar</button>
            <br><br><br>

            <!-- Busca personalizada -->
            <label>Pesquisar por número: </label>
            <input type="number" id="numeroVeiculo" placeholder="Digite o número do veículo">
            <select id="id" name="veiculo"></select>
            <br>
            <button name="pesquisarVeiculo">Pesquisar</button>
            <button name="editarVeiculo">Editar</button>
            <button name="excluirVeiculo">Excluir</button>
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
        $sql = $pdo->prepare("SELECT * FROM veiculos");
    } elseif ($tipo_busca === 'padrao') {
        $sql = $pdo->prepare("SELECT * FROM veiculos WHERE tipo_id = 1");
    } elseif ($tipo_busca === 'executivo') {
        $sql = $pdo->prepare("SELECT * FROM veiculos WHERE tipo_id = 2");
    } elseif ($tipo_busca === 'articulado') {
        $sql = $pdo->prepare("SELECT * FROM veiculos WHERE tipo_id = 3");
    }

    $sql->execute();
    $veiculos = $sql->fetchAll();

    if (count($veiculos) > 0) {
        // Se houver resultados, exiba-os
        echo "<table>
        <caption> Informações dos veículos </caption>
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Número</th>
            <th>Capacidade</th>
            <th>Data de cadastro</th>
            <th>Escalas cadastradas</th>
        </tr>";

        foreach ($veiculos as $veiculo) {
            // Consulta para contar o número de escalas associadas ao veículo
            $sql = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE id = :id");
            $sql->bindParam(':id', $veiculo[0]);
            $sql->execute();
            $numEscalas = $sql->fetchColumn();

            echo "<tr>";
            echo "<td>" . $veiculo[0] . "</td>";
            echo "<td>" . $veiculo[1] . "</td>";
            echo "<td>" . $veiculo[2] . "</td>";
            echo "<td>" . $veiculo[3] . "</td>";
            echo "<td>" . $veiculo[4] . "</td>";
            echo "<td>" . $numEscalas . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<script>alert('Nenhum veículo encontrado para a opção selecionada.')</script>";
    }
}

if (isset($_POST['pesquisarVeiculo'])) {
    // Verifique se o botão "pesquisarVeiculo" foi pressionado
    $pesquisar = strip_tags($_POST['veiculo']);

    $requiredFields = array('veiculo');
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
        $sql = $pdo->prepare("SELECT * FROM veiculos WHERE id = :pesquisar");
        $sql->bindParam(':pesquisar', $pesquisar);
        $sql->execute();
        $veiculos = $sql->fetchAll();

        if (count($veiculos) > 0) {
            echo "<table>
            <caption> Informações do veículo </caption>
            <tr>
                <th>ID</th>
                <th>Tipo</th>
                <th>Número</th>
                <th>Capacidade</th>
                <th>Data de cadastro</th>
                <th>Escalas cadastradas</th>
            </tr>";

            foreach ($veiculos as $veiculo) {
                // Consulta para contar o número de escalas associadas ao veículo
                $sql = $pdo->prepare("SELECT COUNT(*) FROM escalas WHERE id = :id");
                $sql->bindParam(':id', $veiculo[0]);
                $sql->execute();
                $numEscalas = $sql->fetchColumn();

                echo "<tr>";
                echo "<td>" . $veiculo[0] . "</td>";
                echo "<td>" . $veiculo[1] . "</td>";
                echo "<td>" . $veiculo[2] . "</td>";
                echo "<td>" . $veiculo[3] . "</td>";
                echo "<td>" . $veiculo[4] . "</td>";
                echo "<td>" . $numEscalas . "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<script>alert('Erro: não foi encontrado um veículo com este número (id)')</script>";
        }
    }
}
?>


