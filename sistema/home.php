<?php

include('protect.php');
include('conexao.php');

?>
<!DOCTYPE html>
<html>

<head>
    <title>Painel</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="">
        <?php
        $userCod = $_SESSION['codigo'];
        $query = "SELECT usuario.nome, cargo.nome AS nome_cargo, cidade.nome AS nome_cidade, setor.nome AS nome_setor, usuario.data_admissao, usuario.data_demissao, usuario.admin
    FROM usuario
    JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo
    JOIN cidade ON usuario.Codigo_Cidade = cidade.codigo
    JOIN setor ON usuario.Codigo_Setor = setor.codigo
    WHERE usuario.codigo = $userCod";

        $sql_query = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);
        if ($sql_query->num_rows > 0) {
            // Recupera os dados do usuário
            $row = $sql_query->fetch_assoc();
            $nomeFuncionario = $row['nome'];
            $cargo = $row['nome_cargo'];
            $cidade = $row['nome_cidade'];
            $admissao = $row['data_admissao'];
            $demissao = $row['data_demissao'];
            $setor = $row['nome_setor'];
            $admin = $row['admin'];
        }
        ?>



        <!-- --------------------------------------------------------------------------- -->

        <header>
            <div class="nome-usuario">
                <label>Bem-vindo, <?php echo $nomeFuncionario ?></label>
            </div>
        </header>

        <?php
        include('comp/paineDeControle.php')
        ?>

        <section class="">

            <div class="">

                <div class="mural-avisos">
                    <h3>Mural de Avisos</h3>
                    <div class="box-aviso">
                        <a href="">sasa</a>

                    </div>
                    <div class="box-aviso">
                        <a href="">sasa</a>

                    </div>
                    <div class="box-aviso">
                        <a href="">sasa</a>

                    </div>

                </div>

                <div class="mural-avisos">
                    <h3>Aniversariantes do dia</h3>

                    <div style="">
                        <?php
                        $today = date('m-d');

                        // Consulta SQL para obter os usuários de aniversário hoje
                        $sqlFuncionario = "SELECT usuario.nome, usuario.codigo, usuario.data_nascimento, cargo.nome AS nome_cargo, setor.nome AS nome_setor, cargo.nome AS nome_cargo FROM usuario
                        JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo
                         JOIN setor ON usuario.Codigo_Setor = setor.codigo
                         WHERE DATE_FORMAT(data_nascimento, '%m-%d') = '$today'";
                        $resulSQLFuncionario = $mysqli->query($sqlFuncionario);

                        ?>

                        <table class="tabela-sem-bordas">

                            <?php

                            // Verificar se há resultados da consulta
                            if ($resulSQLFuncionario->num_rows > 0) {

                                // Percorrer os resultados e exibir os dados em linhas da tabela HTML
                                while ($row = $resulSQLFuncionario->fetch_assoc()) {
                                    $codUser = $row['codigo'];
                            ?>

                                    <tr class="">
                                        <td class=""><?php echo $row['nome']; ?></td>
                                        <td class=""><?php echo $row['nome_cargo']; ?></td>
                                        <td class=""><?php echo $row['nome_setor']; ?></td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='3'>Ninguém de aniversário hoje.</td></tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>

                <div class="aniversariantes-admissao">

                </div>

            </div>

        </section>

        <footer>
            <?php include('comp/footer.php'); ?>
        </footer>
</body>

</html>