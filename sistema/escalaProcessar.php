<?php

include('protect.php');
include('conexao.php');

if ($_SESSION['admin'] < 1) {
    header('Location: painel.php');
}


$unidadeCod = $_GET['unidade'];

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
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            text-align: center;
            padding: 8px;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        th {
            background-color: #f2f2f2;
        }

        .selected {
            background-color: yellow;
        }
    </style>
</head>

<body>
    <header>

        <?php include('comp/menu.php');

        ?>
    </header>


    <form action="" method="post">

        <section class="conteudo-pag">
            <div class="container">

                <a href="painel.php">voltar</a>
                <h4>Montar Escala </h4>

                <?php echo "Unidade selecionada: " . $unidadeCod; ?>

                <label class="form-label" for="horario">Horario</label>
                <input class="form-control" type="text" name="horario" required>

                <label class="form-label" for="posto">Selecione posto</label>
                <select class="form-control" name="posto" id="posto" required>
                    <option value="">SELECIONE</option>
                    <?php
                    $sqlPosto = "SELECT posto.codigo, posto.nome, posto.Codigo_Unidade, cidade.nome AS cidade_nome, cliente.nome AS cliente_nome, estado.sigla AS estado_sigla  FROM posto
                            JOIN cidade ON posto.Codigo_Cidade = cidade.codigo
                            JOIN cliente ON posto.Codigo_Cliente = cliente.codigo
                            JOIN estado ON cidade.Codigo_Estado = estado.codigo
                            WHERE Codigo_Unidade = $unidadeCod; ";
                    $resultSQLPosto = $mysqli->query($sqlPosto);
                    ?>

                    <?php
                    if ($resultSQLPosto->num_rows > 0) {
                        while ($row = $resultSQLPosto->fetch_assoc()) {
                            $Codigo_Posto = $row['codigo'];
                            $nome = $row['nome'];
                            $cidade = $row['cidade_nome'];
                            $cliente = $row['cliente_nome'];
                            $sigla = $row['estado_sigla'];

                    ?>
                            <option value='<?php echo $Codigo_Posto; ?>'> <?php echo "$nome - $cliente - $cidade/$sigla "; ?></option>;
                    <?php
                        }
                    } else {
                        echo "<option value=''>Nenhum dado encontrado</option>";
                    }


                    ?>
                </select>



                <label class="form-label" for="Codigo_Funcionario">Selecione funcionario</label>
                <select class="form-control" name="Codigo_Funcionario" required>

                    <option value="">SELECIONE</option>
                    <?php


                    $sqlFunc = "SELECT usuario.codigo, usuario.nome, usuario.Codigo_Unidade, cargo.nome AS cargo_nome FROM usuario 
                            JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo
                            WHERE usuario.Codigo_Unidade = $unidadeCod;";
                    $resultSQLFunc = $mysqli->query($sqlFunc);
                    ?>

                    <?php
                    if ($resultSQLFunc->num_rows > 0) {
                        while ($row = $resultSQLFunc->fetch_assoc()) {
                            $Codigo_Func = $row['codigo'];
                            $nome = $row['nome'];
                            $cargo = $row['cargo_nome'];


                    ?>
                            <option value='<?php echo $Codigo_Func; ?>'> <?php echo "$nome - $cargo"; ?></option>;
                    <?php
                        }
                    } else {
                        echo "<option value=''>Nenhum dado encontrado</option>";
                    }
                    ?>
                </select>

                <label class="form-label" for="tipo">Tipo de escala (caso selecione outros, especifique no campo de aviso)</label>
                <select class="form-control" name="tipo" id="" required>
                    <option value="">SELECIONE</option>
                    <option value="12x36">12x36</option>
                    <option value="5x2">5x2</option>
                    <option value="6x1">6x1</option>
                    <option value="4x2">4x2</option>
                    <option value="5x1">5x1</option>
                    <option value="outros">OUTROS</option>
                </select>

                <label class="form-label" for="turno">Turno</label>
                <select class="form-control" name="turno" id="" required>
                    <option value="">SELECIONE</option>
                    <option value="Diurno">Diurno</option>
                    <option value="Noturno">Noturno</option>
                    <option value="Diferenciado">Diferenciado</option>
                </select>

                <label class="form-label" for="aviso">Avisos:</label>
                <textarea class="form-control" name="aviso" id="" cols="30" rows="10"></textarea>


                <input class="form-control" type="submit" value="salvar escala">

    </form>


    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $horario = $_POST['horario'];
        $turno = $_POST['turno'];
        $tipo = $_POST['tipo'];
        $aviso = $_POST['aviso'];
        $Codigo_Funcionario = $_POST['Codigo_Funcionario'];
        $Codigo_Posto = $_POST['posto'];
        $dias =  $_GET['datas'];
        $mes = $_GET['mes'];

        // Preparando a consulta SQL
        $sql = "INSERT INTO escala (horario, turno, mes, dias, tipo, aviso, Codigo_Funcionario, Codigo_Posto) VALUES ('$horario', '$turno', '$mes', '$dias', '$tipo', '$aviso', '$Codigo_Funcionario', '$Codigo_Posto')";

        // Executando a consulta
        if ($mysqli->query($sql) === TRUE) {
            echo "Estado cadastrado com sucesso.";
        } else {
            echo "Erro ao cadastrar estado: " . $mysqli->error;
        }

        // Fechando a conexão
        $mysqli->close();
    } ?>



    </div>
    </section>