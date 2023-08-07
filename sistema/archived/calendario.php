<?php

include('../protect.php');
include('../conexao.php');

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
        .calendario {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .dia {
            border: 1px solid #ccc;
            padding: 5px;
            cursor: pointer;
        }

        .selecionado {
            background-color: yellow;
        }
    </style>
</head>
<?php include('comp/menu.php');

?>

<body>
    <header>
    </header>
    <section class="conteudo-pag">
        <div class="container">




            <form action="">
                <a href="painel.php">voltar</a>
                <h4>Montar Escala </h4>



                <label class="form-label" for="posto">Selecione posto</label>
                <select class="form-control" name="posto" id="posto">
                    <option value="">SELECIONE</option>
                    <?php
                    $sqlPosto = "SELECT posto.nome, posto.Codigo_Unidade, cidade.nome AS cidade_nome, cliente.nome AS cliente_nome  FROM posto 
                            JOIN cidade ON posto.Codigo_Cidade = cidade.codigo
                            JOIN cliente ON posto.Codigo_Cliente = cliente.codigo; ";
                    $resultSQLPosto = $mysqli->query($sqlPosto);
                    ?>

                    <?php
                    if ($resultSQLPosto->num_rows > 0) {
                        while ($row = $resultSQLPosto->fetch_assoc()) {
                            $Codigo_Posto = $row['codigo'];
                            $nome = $row['nome'];
                            $cidade = $row['cidade_nome'];
                            $cliente = $row['cliente_nome'];

                    ?>
                            <option value='<?php echo $Codigo_Posto; ?>'> <?php echo "$nome - $cliente - $cidade "; ?></option>;
                    <?php
                        }
                    } else {
                        echo "<option value=''>Nenhum dado encontrado</option>";
                    }
                    ?>
                </select>
                </select>
                aaa
                <label class="form-label" for="">Selecione o mês</label>
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

                <label class="form-label" for="">Selecione o ano</label>
                <input style="width: 53px;" class="form-control" maxlength="4" oninput="" type="text" name="ano" id="ano" value="<?php echo  date('Y') ?>">


                <input class="form-control" type="submit" value="Gerar Calendário">
            </form>
            <label class="form-label" for="posto">Selecione funcionario</label>
            <select class="form-control" name="posto">

                <option value="">SELECIONE</option>
                <?php
                $Codigo_Unidade = 1;

                $sqlFunc = "SELECT usuario.nome, usuario.Codigo_Unidade, cargo.nome AS cargo_nome FROM usuario 
                            JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo
                            WHERE usuario.Codigo_Unidade = $Codigo_Unidade";
                $resultSQLFunc = $mysqli->query($sqlFunc);
                ?>

                <?php
                if ($resultSQLFunc->num_rows > 0) {
                    while ($row = $resultSQLFunc->fetch_assoc()) {
                        $Codigo_Func = $row['codigo'];
                        $nome = $row['nome'];
                        $cargo = $row['cargo_nome'];


                ?>
                        <option value='<?php echo $Codigo_Posto; ?>'> <?php echo "$nome - $cargo"; ?></option>;
                <?php
                    }
                } else {
                    echo "<option value=''>Nenhum dado encontrado</option>";
                }
                ?>
            </select>

            <div id="calendario-container"></div>
            </form>
            <script>
                // Função para gerar o calendário
                function gerarCalendario(mes, ano) {
                    // Obtém o elemento container do calendário
                    var calendarioContainer = document.getElementById('calendario-container');

                    // Limpa o container
                    calendarioContainer.innerHTML = '';

                    // Obtém o número de dias no mês selecionado
                    var numDias = new Date(ano, mes, 0).getDate();

                    // Cria a grade do calendário
                    var calendario = document.createElement('div');
                    calendario.className = 'calendario';

                    // Loop para criar cada dia do mês
                    for (var dia = 1; dia <= numDias; dia++) {
                        var diaElemento = document.createElement('div');
                        diaElemento.className = 'dia';
                        diaElemento.textContent = dia;

                        // Adiciona um ouvinte de eventos para o clique em um dia
                        diaElemento.addEventListener('click', function() {
                            // Define o dia selecionado como selecionado
                            var dias = document.getElementsByClassName('dia');
                            for (var i = 0; i < dias.length; i++) {
                                dias[i].classList.remove('selecionado');
                            }
                            this.classList.add('selecionado');

                            // Adicione os funcionários disponíveis ao select
                            // Exemplo: busca no banco de dados ou array de funcionários

                            formulario.appendChild(label);
                            formulario.appendChild(select);

                            // Adicione o formulário ao container
                            calendarioContainer.appendChild(formulario);

                            var xhr = new XMLHttpRequest();
                            xhr.onreadystatechange = function() {
                                if (xhr.readyState === 4 && xhr.status === 200) {
                                    var funcionarios = JSON.parse(xhr.responseText);


                                }
                            };
                        });


                        // Adiciona o dia ao calendário
                        calendario.appendChild(diaElemento);
                    }

                    // Adiciona o calendário ao container
                    calendarioContainer.appendChild(calendario);
                }

                // Obtém o formulário
                var form = document.querySelector('form');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    var mes = parseInt(document.getElementById('mes').value);
                    var ano = parseInt(document.getElementById('ano').value);

                    if (isNaN(mes) || isNaN(ano)) {
                        alert('Por favor, selecione o mês e informe o ano corretamente.');
                        return;
                    }

                    gerarCalendario(mes, ano);
                });
            </script>
        </div>
    </section>
    <footer>
        a
    </footer>
    <script src="js/scripts.js"></script>
</body>

</html>