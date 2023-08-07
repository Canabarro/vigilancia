<?php

include('protect.php');
include('conexao.php');

if ($_SESSION['admin'] < 1) {
    header('Location: painel.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Montar Escala</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">

    <style>
        /* Estilos CSS para o calendário */
    </style>
</head>
<?php include('comp/menu.php');

?>

<body>
    <header>
    </header>
    <section class="conteudo-pag">
        <div class="container">

            <a href="painel.php">voltar</a>
            <h4>Montar Escala </h4>

            <form action="escalaProcessar.php" method="GET">

                <label class="form-label" for="posto">Selecione a Unidade</label>
                <select class="form-control" name="unidade" id="posto" required>
                    <option value="">SELECIONE</option>
                    <?php
                    $sqlPosto = "SELECT unidade.codigo, unidade.nome, cidade.nome AS cidade_nome, estado.sigla AS estado_sigla FROM unidade 
                            JOIN cidade ON unidade.Codigo_Cidade_UN = cidade.codigo
                            JOIN estado ON cidade.Codigo_Estado = estado.codigo;";
                    $resultSQLPosto = $mysqli->query($sqlPosto);
                    ?>

                    <?php
                    if ($resultSQLPosto->num_rows > 0) {
                        while ($row = $resultSQLPosto->fetch_assoc()) {
                            $Codigo_Unidade = $row['codigo'];
                            $nomeUnidade = $row['nome'];
                            $cidade = $row['cidade_nome'];
                            $sigla = $row['estado_sigla'];


                    ?>
                            <option value='<?php echo $Codigo_Unidade; ?>'> <?php echo "$nomeUnidade - $cidade - $sigla "; ?></option>;
                    <?php
                        }
                    } else {
                        echo "<option value=''>Nenhum dado encontrado</option>";
                    }
                    ?>
                </select>

                <h1>Calendário</h1>

                <table class="calendario" id="calendario">
                    <tr class="calendariotr">
                        <th>Domingo</th>
                        <th>Segunda-feira</th>
                        <th>Terça-feira</th>
                        <th>Quarta-feira</th>
                        <th>Quinta-feira</th>
                        <th>Sexta-feira</th>
                        <th>Sábado</th>
                    </tr>
                </table>

                <label class="form-label" for="" required>Selecione o mês</label>
                <select class="form-control" name="mes" id="mes">
                    <option value="">SELECIONE</option>
                    <option value="1">Janeiro</option>
                    <option value="2">Fevereiro</option>
                    <option value="3">Março</option>
                    <option value="4">Abril</option>
                    <option value="5">Maio</option>
                    <option value="6">Junho</option>
                    <option value="7">Julho</option>
                    <option value="8">Agosto</option>
                    <option value="9">Setembro</option>
                    <option value="10">Outubro</option>
                    <option value="11">Novembro</option>
                    <option value="12">Dezembro</option>
                </select>

                <label class="form-label" for="ano">Ano:</label>
                <input class="form-control" maxlength="4" style="width: 53px;" type="text" id="ano" name="ano" required value="<?php echo date('Y') ?>">



                <br><input class="form-btn" type="submit" value="Gerar Calendário">

            </form>
            <br>
            <button class="form-btn" id="aplicar-datas" onclick="aplicarDatas()">Proxima Etapa</button>

            <script>
                // Adiciona um ouvinte de eventos para o envio do formulário
                var formulario = document.querySelector('form');
                formulario.addEventListener('submit', function(e) {
                    e.preventDefault();
                    gerarCalendario();
                });

                // Função para gerar o calendário
                function gerarCalendario() {
                    var mesInput = document.getElementById('mes');
                    var anoInput = document.getElementById('ano');
                    var calendario = document.getElementById('calendario');

                    // Remove todas as linhas do calendário, exceto a primeira (cabeçalho)
                    while (calendario.rows.length > 1) {
                        calendario.deleteRow(1);
                    }

                    // Obtém o mês e ano selecionados
                    var mes = mesInput.value;
                    var ano = anoInput.value;

                    // Cria uma data para o primeiro dia do mês
                    var primeiroDia = new Date(ano, mes - 1, 1);

                    // Obtém o número de dias no mês
                    var numDias = new Date(ano, mes, 0).getDate();

                    // Obtém o dia da semana do primeiro dia do mês
                    var diaSemana = primeiroDia.getDay();

                    // Inicia a contagem dos dias do mês
                    var dia = 1;

                    // Loop para criar as linhas do calendário
                    while (dia <= numDias) {
                        var linha = calendario.insertRow();

                        // Loop para criar as colunas do calendário
                        for (var i = 0; i < 7; i++) {
                            var celula = linha.insertCell();

                            // Verifica se o dia atual é válido dentro do mês
                            if ((linha.rowIndex === 1 && i < diaSemana) || dia > numDias) {
                                celula.innerHTML = '&nbsp;';
                            } else {
                                celula.textContent = dia;
                                celula.addEventListener('click', function() {
                                    this.classList.toggle('selected');
                                    atualizarSelecao();
                                });

                                dia++;
                            }
                        }
                    }
                }

                // Função para atualizar a seleção dos dias
                function atualizarSelecao() {
                    var diasSelecionados = document.querySelectorAll('#calendario .selected');
                    var diasSelecionadosArray = Array.from(diasSelecionados);
                    var dias = diasSelecionadosArray.map(function(diaSelecionado) {
                        return diaSelecionado.textContent;
                    });

                    console.log(dias);
                }

                // Função para enviar as datas selecionadas para o servidor
                function aplicarDatas() {
                    var diasSelecionados = document.querySelectorAll('#calendario .selected');
                    var diasSelecionadosArray = Array.from(diasSelecionados);
                    var datas = diasSelecionadosArray.map(function(diaSelecionado) {
                        return diaSelecionado.textContent;
                    });

                    // Cria um campo de formulário oculto para enviar as datas selecionadas
                    var inputDatas = document.createElement('input');
                    inputDatas.type = 'hidden';
                    inputDatas.name = 'datas';
                    inputDatas.value = datas.join(',');

                    // Anexa o campo de formulário ao formulário existente
                    var formulario = document.querySelector('form');
                    formulario.appendChild(inputDatas);

                    // Envie o formulário
                    formulario.submit();
                }
            </script>
</body>

</html>