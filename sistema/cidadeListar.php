<?php

include('protect.php');
include('conexao.php');

if ($_SESSION['admin'] < 1) {
    header('Location: home.php');
}
$registrosPorPagina = 10; // Número de registros exibidos por página

// Obter o número total de registros na tabela
$sqlTotalRegistros = "SELECT COUNT(*) AS total FROM cidade";
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

$sql = "SELECT cidade.nome, cidade.codigo, estado.nome AS nome_estado FROM cidade
   JOIN estado ON cidade.Codigo_Estado = estado.codigo
   LIMIT $inicio, $registrosPorPagina;";
$resulSQL = $mysqli->query($sql);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>administrador</title>
    <link rel="stylesheet" href="css/all.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
</head>

<body>
    <header>
        <?php include('comp/menu.php') ?>

    </header>
    <section class="conteudo-pag">
        <div class="container">

            <h1>Listagem - Cidades</h1>

            <div class="opcoes-line">
                <a href="cidadeCadastrar.php">Cadastrar</a> <a href="">Consultar</a> <a href="adminPage.php">voltar</a>
            </div><br>

            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Estado</th>
                    <th>Ações</th>
                </tr>
                <?php

                // Verificar se há resultados da consulta
                if ($resulSQL->num_rows > 0) {

                    // Percorrer os resultados e exibir os dados em linhas da tabela HTML
                    while ($row = $resulSQL->fetch_assoc()) {
                        $codCidade = $row['codigo'];
                ?>
                        <tr>
                            <td><?php echo $codCidade; ?> </td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['nome_estado']; ?></td>
                            <td>
                                <a class="acoes-btn" href='cidadeEditar.php?codigo=<?php echo $codCidade ?>'>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </a>
                                <a class="acoes-btn" href='cidadeExcluir.php?codigo=<?php echo $codCidade ?>'>
                                    <i class='fa-solid fa-trash'></i></a><a href=''>
                                </a>
                                <a class="acoes-btn" href=""><i class='fa-solid fa-circle-info'></i></a>
                            </td>
                        </tr> <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
                        }
                                ?>
            </table>

            <div class="center">
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