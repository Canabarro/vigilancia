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


$sql = "SELECT cliente.nome, cliente.codigo, cliente.cnpj, cidade.nome AS nome_cidade, estado.sigla AS sigla_estado FROM cliente
   JOIN cidade ON cliente.Codigo_Cidade = cidade.codigo
   JOIN estado ON cidade.Codigo_Estado = estado.codigo
    LIMIT $inicio, $registrosPorPagina;";
$resulSQL = $mysqli->query($sql);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>administrador</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>
        <?php include('comp/menu.php') ?>
    </header>
    <section class="conteudo-pag">
        <div class="container">
            <h1>Listagem - Clientes</h1>

            <div class="opcoes-line">
                <a href="clienteCadastrar.php">Cadastrar</a> <a href="">Consultar</a><a href="adminPage.php">voltar</a>
            </div><br>


            <table>
                <tr>
                    <th>Codigo</th>
                    <th>Nome</th>
                    <th>Cidade</th>
                    <th>CNPJ</th>
                    <th>Ações</th>
                </tr>
                <?php

                // Verificar se há resultados da consulta
                if ($resulSQL->num_rows > 0) {

                    // Percorrer os resultados e exibir os dados em linhas da tabela HTML
                    while ($row = $resulSQL->fetch_assoc()) {
                        $codigo = $row['codigo'];
                ?>
                        <tr>
                            <td><?php echo $codigo; ?> </td>
                            <td><?php echo $row['nome']; ?></td>
                            <td><?php echo $row['nome_cidade'] . " - " . $row['sigla_estado']; ?></td>
                            <td><?php echo $row['cnpj']; ?></td>
                            <td>
                                <a class="acoes-btn" href='clienteEditar.php?codigo=<?php echo $codigo ?>'>
                                    <i class='fa-solid fa-pen-to-square'></i>
                                </a>
                                <a class="acoes-btn" href='clienteExcluir.php?codigo=<?php echo $codigo ?>'>
                                    <i class='fa-solid fa-trash'></i></a><a href=''>
                                </a>
                                <a class="acoes-btn" href='clienteView.php?codigo=<?php echo $codigo ?>'>
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
    <footer>


    </footer>
</body>

</html>