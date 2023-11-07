$(document).ready(function() {
    // Buscar cargos usando AJAX
    $.ajax({
                type: "GET",
                url: "../includes/AJAX_carregarCargos.php", // Arquivo PHP para buscar cargos
                dataType: "json", // Define o tipo de dados esperado
                success: function (data) {
                    var options = "";
                    data.forEach(function (cargos) {
                        options += "<option value='" + cargos.id + "'>" + cargos.cargo + "</option>";
                    });
                    $("#cargo_id").html(options);
                }
            });
    });

    $(document).ready(function () {
        // Função para carregar os funcionários
        function carregarFuncionarios() {
            $.ajax({
                type: "GET",
                url: "../includes/AJAX_carregarFuncionarios.php",
                dataType: "json",
                success: function (data) {
                    var select = $("#funcionario_id");
    
                    // Limpar o select
                    select.empty();
    
                    // Adicionar as opções com cores corretas
                    data.forEach(function (funcionario) {
                        var optionClass = funcionario.em_escala == 1 ? "vermelho" : "verde";
                        var option = $("<option></option>")
                            .val(funcionario.id)
                            .text(funcionario.nome + " - " + funcionario.matricula)
                            .addClass(optionClass);
    
                        select.append(option);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Erro na solicitação AJAX: " + status + " - " + error);
                }
            });
        }
    
        // Carregar todos os funcionários ao carregar a página
        carregarFuncionarios();
    
        // Manipular o evento de digitação no campo de input
        $("#nomeFuncionario").on("keyup", function () {
            var nome = $(this).val().toLowerCase();
    
            // Filtrar os funcionários com base no nome digitado
            $("#funcionario_id option").each(function () {
                var optionNome = $(this).text().toLowerCase();
                if (optionNome.indexOf(nome) === -1) {
                    $(this).hide();
                } else {
                    $(this).show();
                }
            });
        });
    });