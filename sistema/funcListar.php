<?php

include('protect.php');
include('conexao.php');

if ($_SESSION['admin'] < 1) {
    header('Location: painel.php');
}

$registrosPorPagina = 10; // Número de registros exibidos por página

// Obter o número total de registros na tabela
$sqlTotalRegistros = "SELECT COUNT(*) AS total FROM usuario";
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


$sqlFuncionario = "SELECT usuario.nome, usuario.codigo, cargo.nome AS nome_cargo, setor.nome AS nome_setor, cargo.nome AS nome_cargo FROM usuario
   JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo
    JOIN setor ON usuario.Codigo_Setor = setor.codigo
    LIMIT $inicio, $registrosPorPagina;";
$resulSQLFuncionario = $mysqli->query($sqlFuncionario);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>administrador</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/menu.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
-->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <?php include('comp/menu.php') ?>
    </header>
    <section class="conteudo-pag">
        <div class="container">
            <h1>Listagem - Funcionários</h1>

            <div class="opcoes-line">
                <a href="funcCadastrar.php">Cadastrar</a> <a href="">Consultar</a><a href="adminPage.php">voltar</a>
            </div><br>


            <table>
                <tr>
                    <th class="">Codigo</th>
                    <th class="">Nome</th>
                    <th class="">Cargo</th>
                    <th class="">Setor</th>
                    <th class="">Ações</th>
                </tr>
                <?php

                // Verificar se há resultados da consulta
                if ($resulSQLFuncionario->num_rows > 0) {

                    // Percorrer os resultados e exibir os dados em linhas da tabela HTML
                    while ($row = $resulSQLFuncionario->fetch_assoc()) {
                        $codUser = $row['codigo'];
                ?>
                        <tr class="">
                            <td class=""><?php echo $codUser; ?> </td>
                            <td class=""><?php echo $row['nome']; ?></td>
                            <td class=""><?php echo $row['nome_cargo']; ?></td>
                            <td class=""><?php echo $row['nome_setor']; ?></td>
                            <td class="">
                                <a class="acoes-btn" href='funcEditar.php?codigo=<?php echo $codUser ?>'>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </a>
                                <a class="acoes-btn" href='funcExcluir.php?codigo=<?php echo $codUser ?>'>
                                    <i class='fa-solid fa-trash'></i></a><a href=''>
                                </a>
                                <a class="acoes-btn" href='funcView.php?codigo=<?php echo $codUser ?>'>
                                    <i class='fa-solid fa-circle-info'></i>
                                </a>
                        </tr> <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
                        }
                                ?>
            </table>
        </div>
    </section>
    <footer>


    </footer>
</body>

</html>