<?php
require "conexaoBanco.php";

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
?>
