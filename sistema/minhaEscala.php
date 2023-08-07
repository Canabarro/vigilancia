<?php

include('protect.php');
include('conexao.php');

$userCod = $_SESSION['codigo']

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minha Escala</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">

    <style>
        /* Estilos CSS para o calendário */
    </style>
</head>

<body>
    <header>
    </header>
    <section class="conteudo-pag">
        <div class="container">

            <a href="painel.php">voltar</a>
            <h4>Minha Escala </h4>

            <form action="escalaProcessar.php" method="GET">

                <?php

                $sqlEscala = "SELECT escala.codigo, escala.mes, escala.dias, escala.mes, escala.horario, escala.turno, escala.tipo, escala.aviso, unidade.nome AS unidade_nome, cidade.nome AS cidade_nome, estado.sigla AS estado_sigla, posto.nome AS posto_nome, cliente.nome AS cliente_nome
FROM escala
JOIN posto ON escala.Codigo_Posto = posto.codigo
JOIN unidade ON posto.Codigo_Unidade = unidade.codigo
JOIN cidade ON posto.Codigo_Cidade = cidade.codigo
JOIN estado ON cidade.Codigo_Estado = estado.codigo
JOIN cliente ON posto.Codigo_Cliente = cliente.codigo
WHERE Codigo_Funcionario  = $userCod";
                $resultSQLEscala = $mysqli->query($sqlEscala);

                ?>

                <div class="painelDados">
                    <h4>Escala de posto fixo</h4>
                    <table>
                        <tr>
                            <th>Local</th>
                            <th>sas</th>
                        </tr>
                    </table>

                </div>
                <br>
                <div class="painelDados">
                    <h4>Escala variavel</h4>
                    <table>
                        <tr>
                            <th>Codigo</th>
                            <th>Mês</th>
                            <th>Cidade</th>
                            <th>Posto</th>
                            <th>Cliente</th>
                            <th>Unidade</th>
                            <th>Ações</th>
                        </tr>
                        <?php

                        // Verificar se há resultados da consulta
                        if ($resultSQLEscala->num_rows > 0) {

                            // Percorrer os resultados e exibir os dados em linhas da tabela HTML
                            while ($row = $resultSQLEscala->fetch_assoc()) {

                        ?>
                                <tr>

                                    <td><?php echo $row['codigo']; ?></td>
                                    <td><?php echo $row['mes']; ?></td>
                                    <td><?php echo $row['cidade_nome'] . "/" . $row['estado_sigla']; ?></td>
                                    <td><?php echo $row['posto_nome']; ?></td>
                                    <td><?php echo $row['cliente_nome']; ?></td>
                                    <td><?php echo $row['unidade_nome']; ?></td>
                                    <td>
                                        <a class="acoes-btn" href='funcView.php?codigo=<?php echo $codUser ?>'> mais dados
                                            <!-- <i class='fa-solid fa-circle-info'></i> --></a>
                                </tr> <?php
                                    }
                                } else {
                                    echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
                                }
                                        ?>
                    </table>
                </div>
                <!-- ----------------------------------------------------------- -->

                <!--  <h1>Calendário</h1>

                    <table class="calendario" id="calendario">
                        <tr>
                            <th>Domingo</th>
                            <th>Segunda-feira</th>
                            <th>Terça-feira</th>
                            <th>Quarta-feira</th>
                            <th>Quinta-feira</th>
                            <th>Sexta-feira</th>
                            <th>Sábado</th>
                        </tr>
                    </table> -



                <input type="submit" value="Gerar Calendário"> -->
            </form>







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