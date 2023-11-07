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

$(document).ready(function () {
    // Função para carregar as escalas
    function carregarEscalas() {
        $.ajax({
            type: "GET",
            url: "../includes/AJAX_carregarNEscalas.php",
            dataType: "json",
            success: function (data) {
                var options = "";
                data.forEach(function (nEscalas) {
                    options +=
                        "<option value='" +
                        nEscalas.id +
                        "'>" +
                        nEscalas.numero_escala +
                        "</option>";
                });
                $("#escala_id").html(options);
            },
        });
    }

    // Carregar todas as escalas ao carregar a página
    carregarEscalas();

    // Manipular o evento de digitação no campo de input
    $("#numeroEscalas").on("keyup", function () {
        var escalaDigitada = $(this).val().toLowerCase();

        // Iterar sobre as opções do select
        $("#escala_id option").each(function () {
            var numeroEscala = $(this).text().toLowerCase();
            if (numeroEscala.indexOf(escalaDigitada) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
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

$(document).ready(function () {
    // Função para carregar motoristas usando AJAX
    function carregarMotoristas(){
    $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarMotoristas.php",
        dataType: "json",
        success: function (data) {
            var select = $("#motorista_id");

            // Adicionar as opções com cores corretas
            data.forEach(function (motorista) {
                var optionClass = motorista.em_escala == 1 ? "vermelho" : "verde";
                var option = $("<option></option>")
                    .val(motorista.id)
                    .text(motorista.nome + " - " + motorista.matricula)
                    .addClass(optionClass);

                select.append(option);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
    });
    }

    // Carregar motoristas ao carregar a página
    carregarMotoristas();
    
    // Manipular o evento de digitação no campo de input
    $("#nomeMotorista").on("keyup", function () {
        var nome = $(this).val().toLowerCase();

        // Filtrar os funcionários com base no nome digitado
        $("#motorista_id option").each(function () {
            var optionNome = $(this).text().toLowerCase();
            if (optionNome.indexOf(nome) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });

});

$(document).ready(function () {
    // Função para carregar cobradores usando AJAX
    function carregarCobradores(){
    $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarCobradores.php",
        dataType: "json",
        success: function (data) {
            var select = $("#cobrador_id");

            // Adicionar as opções com cores corretas
            data.forEach(function (cobrador) {
                var optionClass = cobrador.em_escala == 1 ? "vermelho" : "verde";
                var option = $("<option></option>")
                    .val(cobrador.id)
                    .text(cobrador.nome + " - " + cobrador.matricula)
                    .addClass(optionClass);

                select.append(option);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
    });
   }

   // Carregar cobradores ao carregar a página
   carregarCobradores();
   
    // Manipular o evento de digitação no campo de input
    $("#nomeCobrador").on("keyup", function () {
        var nome = $(this).val().toLowerCase();

        // Filtrar os funcionários com base no nome digitado
        $("#cobrador_id option").each(function () {
            var optionNome = $(this).text().toLowerCase();
            if (optionNome.indexOf(nome) === -1) {
                $(this).hide();
            } else {
                $(this).show();
            }
        });
    });
});

// Carregar veículos cadastrados em uma escala
$(document).ready(function () {
    // Função para carregar veículos em escala de trabalho usando AJAX
    function carregarVeiculosComEscala(){
    $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarVeiculosComEscala.php",
        dataType: "json",
        success: function (data) {
            var select = $("#veiculo_idPesquisa");

            data.forEach(function (veiculo) {
                var option = $("<option></option>")
                    .val(veiculo.id)
                    .text(veiculo.numero);

                select.append(option);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
    });
  }

   // Carrega todos os veículos ao carregar a página
   carregarVeiculosComEscala();

   // Manipular o evento de digitação no campo de input
   $("#veiculoNumero").on("keyup", function () {
    var numeroDigitado = $(this).val().toLowerCase();

    // Iterar sobre as opções do select
    $("#veiculo_idPesquisa option").each(function () {
        var numeroVeiculo = $(this).text().toLowerCase();
        if (numeroVeiculo.indexOf(numeroDigitado) === -1) {
            $(this).hide();
        } else {
            $(this).show();
        }
    });
  });
});

// Carregar funcionários cadastrados em uma escala
$(document).ready(function () {
    // Função para carregar funcionários em escala de trabalho usando AJAX
    function carregarFuncionariosComEscala(){
    $.ajax({
        type: "GET",
        url: "../includes/AJAX_carregarFuncComEscala.php",
        dataType: "json",
        success: function (data) {
            var select = $("#funcionario_idPesquisa");

            data.forEach(function (funcionario) {
                var option = $("<option></option>")
                    .val(funcionario.id)
                    .text(funcionario.nome);

                select.append(option);
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error("Erro na requisição AJAX: " + textStatus, errorThrown);
        }
    });
  }

   // Carrega todos os veículos ao carregar a página
   carregarFuncionariosComEscala();

   // Manipular o evento de digitação no campo de input
   $("#nomeFuncionarioPesquisa").on("keyup", function () {
    var nomeFuncionarioPesquisa = $(this).val().toLowerCase();

    // Iterar sobre as opções do select
    $("#funcionario_idPesquisa option").each(function () {
        var nomeFuncionarioPesquisa = $(this).text().toLowerCase();
        if (nomeFuncionarioPesquisa.indexOf(nomeFuncionarioPesquisa) === -1) {
            $(this).hide();
        } else {
            $(this).show();
        }
    });
  });
});

