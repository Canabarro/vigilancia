<?php

include('protect.php');
include('conexao.php');

if ($_SESSION['admin'] < 1) {
    header('Location: painel.php');
}
$registrosPorPagina = 10; // Número de registros exibidos por página

// Obter o número total de registros na tabela
$sqlTotalRegistros = "SELECT COUNT(*) AS total FROM estado";
$resulTotalRegistros = $mysqli->query($sqlTotalRegistros);
$totalRegistros = $resulTotalRegistros->fetch_assoc()['total'];

// Calcular o número total de páginas
$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

// Verificar se o parâmetro 'pagina' foi enviado na URL
if (isset($_GET['pagina'])) {
    $paginaAtual = $_GET['pagina'];
} else {
    $paginaAtual = 1; // Página atual padrão é a primeira página
}

$inicio = ($paginaAtual - 1) * $registrosPorPagina; // Índice inicial para a consulta SQL

$sqlEstado = "SELECT * FROM estado
LIMIT $inicio, $registrosPorPagina;";

$resulSQLEstado = $mysqli->query($sqlEstado);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>administrador</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
</head>

<body>
    <header>
        <?php include('comp/menu.php') ?>
    </header>
    <section class="conteudo-pag">
    <div class="container">
        <h1>Listagem - Estados</h1>

        <div class="opcoes-line">
            <a href="estadoCadastrar.php">Cadastrar</a> <a href="">Consultar</a><a href="adminPage.php">voltar</a>
        </div><br>

            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Sigla</th>
                    <th>Ações</th>
                </tr>
                <?php

                // Verificar se há resultados da consulta
                if ($resulSQLEstado->num_rows > 0) {

                    // Percorrer os resultados e exibir os dados em linhas da tabela HTML
                    while ($row = $resulSQLEstado->fetch_assoc()) {
                        $codEstado = $row['codigo'];
                ?>
                        <tr>
                            <td><?php echo $codEstado; ?> </td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['sigla']; ?></td>
                            <td><a href='estadoEditar.php?codigo=<?php echo $codEstado ?>'> <i class='fa-solid fa-pen-to-square'></i></a><a href='estadoExcluir.php?codigo=<?php echo $codEstado ?>'> <i class='fa-solid fa-trash'></i></a><a href=''> <i class='fa-solid fa-circle-info'></i></a>
                        </tr> <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
                        }
                                ?>
            </table>
            <div class="center-ligin">
                <div class="pagination">
                    <?php


                    // Exibir links para cada página
                    for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
                        if ($totalRegistros >= 10) {
                            echo "<a href='?pagina=$pagina'>$pagina</a>";
                        }
                    }

                    ?>

                </div>
            </div>
        </div>
    </section>
</body>

</html>