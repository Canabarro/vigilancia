<?php

include('protect.php');
include('conexao.php');

if ($_SESSION['admin'] < 1) {
    header('Location: painel.php');
}

$registrosPorPagina = 10; // Número de registros exibidos por página

// Obter o número total de registros na tabela
$sqlTotalRegistros = "SELECT COUNT(*) AS total FROM setor";
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

$sqlSetor = "SELECT * FROM setor
LIMIT $inicio, $registrosPorPagina;";

$resulSQLSetor = $mysqli->query($sqlSetor);


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
            <a href="adminPage.php">voltar</a>
            <h1>Listagem - Setores</h1>

            <div>
                <a href="setorCadastrar.php">Cadastrar</a> <a href="">Consultar</a>
            </div><br>



            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Ações</th>
                </tr>
                <?php

                // Verificar se há resultados da consulta
                if ($resulSQLSetor->num_rows > 0) {

                    // Percorrer os resultados e exibir os dados em linhas da tabela HTML
                    while ($row = $resulSQLSetor->fetch_assoc()) {

                ?>
                        <tr>
                            <td><?php echo $row['codigo']; ?> </td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><a href='setorEditar.php?codigo=<?php echo $row['codigo'] ?>'> <i class='fa-solid fa-pen-to-square'></i></a><a href='setorExcluir.php?codigo=<?php echo $row['codigo'] ?>'> <i class='fa-solid fa-trash'></i></a><a href=''> <i class='fa-solid fa-circle-info'></i></a>
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

                    if ($totalRegistros >= 1) {
                        // Exibir links para cada página
                        for ($pagina = 1; $pagina <= $totalPaginas; $pagina++) {
                            echo "<a href='?pagina=$pagina'>$pagina</a>";
                        }
                    }
                    ?>

                </div>
            </div>
        </div>
    </section>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
-->
</body>

</html>