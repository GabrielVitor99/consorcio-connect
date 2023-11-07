$(document).ready(function() {
    // Buscar tipos de veículo usando AJAX
    $.ajax({
                type: "GET",
                url: "../includes/AJAX_carregarTipos.php", // Arquivo PHP para buscar tipos
                dataType: "json", // Define o tipo de dados esperado
                success: function (data) {
                    var options = "";
                    data.forEach(function (tipos) {
                        options += "<option value='" + tipos.id + "'>" + tipos.tipo + "</option>";
                    });
                    $("#tipo_id").html(options);
                }
            });
    });

    $(document).ready(function () {
        // Função para carregar veículos usando AJAX
        function carregarVeiculos(){
        $.ajax({
            type: "GET",
            url: "../includes/AJAX_carregarVeiculos.php",
            dataType: "json",
            success: function (data) {
                var select = $("#veiculo_id");
    
                // Adicionar as opções com cores corretas
                data.forEach(function (veiculo) {
                    var option = $("<option></option>")
                        .val(veiculo.id)
                        .text(veiculo.numero)
                        .addClass(veiculo.cor);
    
                    select.append(option);
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
            }
        });
      }
    
       // Carrega todos os veículos ao carregar a página
       carregarVeiculos();
    
       // Manipular o evento de digitação no campo de input
       $("#numeroVeiculo").on("keyup", function () {
        var numeroDigitado = $(this).val().toLowerCase();
    
        // Iterar sobre as opções do select
        $("#veiculo_id option").each(function () {
            var numeroVeiculo = $(this).text().toLowerCase();
            if (numeroVeiculo.indexOf(numeroDigitado) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
      });
    });