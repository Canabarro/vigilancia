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


$sql = "SELECT unidade.codigo, unidade.nome, unidade.cnpj, usuario.nome AS nome_resp, cargo.nome AS resp_cargo, cidade.nome AS nome_cidade, estado.sigla AS nome_sigla
FROM unidade
INNER JOIN cidade ON unidade.Codigo_Cidade_UN = cidade.codigo
INNER JOIN estado ON cidade.Codigo_Estado = estado.codigo
INNER JOIN usuario ON unidade.Codigo_Responsavel = usuario.codigo
INNER JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo;";
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
            <h1>Listagem - Unidades</h1>
            <div class="opcoes-line">
                <a href="unidadeCadastrar.php">Cadastrar</a> <a href="">Consultar</a> <a href="adminPage.php">voltar</a>
            </div><br>

            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>CNPJ</th>
                    <th>Responsável</th>
                    <th>Ações</th>
                </tr>
                <?php

                // Verificar se há resultados da consulta
                if ($resulSQL->num_rows > 0) {

                    // Percorrer os resultados e exibir os dados em linhas da tabela HTML
                    while ($row = $resulSQL->fetch_assoc()) {
                        $codUser = $row['codigo'];
                ?>
                        <tr>
                            <td><?php echo $codUser; ?> </td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['nome_cidade'] . " - " . $row['nome_sigla']; ?></td>
                            <td><?php echo $row['cnpj'] ?></td>
                            <td><?php echo $row['nome_resp'] . " - " . $row['resp_cargo'] ?></td>
                            <td>
                                <a class="acoes-btn" href='unidadeEditar.php?codigo=<?php echo $codUser ?>'>
                                    <i class='fa-solid fa-pen-to-square'></i></a> <a href='unidadeExcluir.php?codigo=<?php echo $codUser ?>'>
                                </a>
                                <a class="acoes-btn">
                                    <i class='fa-solid fa-trash'></i></a><a href='unidadeExcluir.php'>
                                </a>
                                <a class="acoes-btn" href="unidadeExcluir.php">
                                    <i class='fa-solid fa-circle-info'></i>
                                </a>
                            </td>
                        </tr> <?php
                            }
                        } else {
                            echo "<tr><td colspan='3'>Nenhum dado encontrado</td></tr>";
                        }
                                ?>
            </table>
        </div>
    </section>
    <!--<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
-->
    <footer>


    </footer>
</body>

</html>