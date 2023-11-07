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

    <!-- Formulário para a tabela "escalas" -->
    <div class="container">
        <h2>Formulário de Inserção de Escalas</h2>
        <form action="#" method="POST">
            <label for="numero_escala">Número de escala:</label>
            <input type="text" id="numero_escala" name="numero_escala">

             <!-- Busca personalizada -->
            <label for="pesquisarPorVeiculo">Veículo: </label>
            <input type="number" id="numeroVeiculo" placeholder="Digite o número do veículo">
            <label>AZUL: PADRAO, AMARELO: EXECUTIVO, ROXO: ARTICULADO</label>
            <select id="veiculo_id" name="veiculo"></select>

            <!-- Busca personalizada -->
            <label for="pesquisarPorMotorista">Motorista: </label>
            <input type="text" id="nomeMotorista" placeholder="Digite o nome do motorista">
            <label>VERMELHO JÁ TEM ESCALA, VERDE NÃO TEM</label>
            <select id="motorista_id" name="motorista"></select>

            <!-- fazer por padrão sem, ao clicar na check-box aparecer -->
            <input type="checkbox"> <label for="checkbox">Incluir cobrador</label>
            
            <!-- Busca personalizada -->
            <label for="pesquisarPorCobrador">Cobrador: </label>
            <input type="text" id="nomeCobrador" placeholder="Digite o nome do cobrador">
            <label>VERMELHO JÁ TEM ESCALA, VERDE NÃO TEM</label>
            <select id="cobrador_id" name="cobrador"></select>

            <label for="horario_inicio">Horário de início:</label>
            <input type="time" id="horario_inicio" name="horario_inicio">

            <label for="tempo_intervalo">Tempo de intervalo:</label>
            <input type="time" id="tempo_intervalo" name="tempo_intervalo">

            <label for="horario_final">Horário final:</label>
            <input type="time" id="horario_final" name="horario_final">

            <label for="fileInput">Selecione um arquivo:</label>
            <input type= "file" id="fileInput" name="file"> <br><br>

            <button name='cadastrarEscala'>Cadastrar escala</button>
        </form>
    </div>

    <?php
     
     if(isset($_POST['cadastrarEscala'])){
        require "../includes/INSERIR_cadastrarEscala.php";
     }

    ?>

    <div class="container">
     <h2>Formulário de busca de Escalas de trabalho</h2>
        <form action="#" method="POST">
            <!-- Pesquisar por funcionário -->
            <label for="pesquisarPorFuncionario">Pesquisar por funcionário: </label>
            <input type="text" id="nomeFuncionarioPesquisa" placeholder="Digite o nome do funcionário">
            <select id="funcionario_idPesquisa" name="pesquisaPorFuncionario"></select>

            <button name="PesquisarPorFuncionario">Exibir escala</button>

            <!-- Pesquisar por número de escala (revisar depois) -->
            <br><br><br>
            <label for="pesquisarPorNumeroEscala">Pesquisar por número de escala: </label>
            
            <input type="text" id="numeroEscalas" placeholder="Digite o número da escala">
            <select id="escala_id" name="pesquisarPorEscalaN"></select>
            
            <button name="PesquisarPorNumeroEscala">Exibir escala</button>


            <!-- Pesquisar por veículos -->
            <br><br><br>
            <label for="pesquisarPorVeiculo">Pesquisar por veículo: </label>
            <input type="number" id="veiculoNumero" placeholder="Digite o número do veículo">
            <select id="veiculo_idPesquisa" name="pesquisaPorVeiculo"></select>

            <button name="PesquisarPorVeiculoEscala">Exibir escala</button>

            <br><br>
       </form>
    </div>
</body>
</html>

<?php

            if(isset($_POST['PesquisarPorFuncionario'])){
                require "../includes/pesquisarEscalaPorNome.php";

            }
                
            if(isset($_POST['PesquisarPorNumeroEscala'])){
                require "../includes/pesquisarEscalaPorNumero.php";

               
            }

            if(isset($_POST['PesquisarPorVeiculoEscala'])){
                require "../includes/pesquisarEscalaPorVeiculo.php";

               
            }
            

            ?>

