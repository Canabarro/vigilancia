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

    <div class="container">
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

        <section class="conteudo-pag">

            <div class="container">

                <div class="painel-info">

                    <table class="tabela-sem-bordas">
                        <tr>
                            <td class="alinhado-direita">Nome Completo</td>
                            <td class="alinhado-esquerda"> <?php echo $nomeFuncionario ?></td>
                        </tr>
                        <tr>
                            <td class="alinhado-direita">Cargo</td>
                            <td class="alinhado-esquerda"> <?php echo $cargo ?></td>
                        </tr>
                        <tr>
                            <td class="alinhado-direita">Departamento/Setor</td>
                            <td class="alinhado-esquerda"><?php echo $setor ?></td>
                        </tr>
                        <tr>
                            <td class="alinhado-direita">Data de Admissão</td>
                            <td class="alinhado-esquerda"><?php echo implode('/', array_reverse(explode('-', $admissao))) ?></td>
                        </tr>

                        <?php
                        if (!$demissao) {
                            $inicio = new DateTime($admissao);
                            $demissao = new DateTime();
                            $tempoServico = $inicio->diff($demissao);
                        ?>
                            <tr>
                                <td class="alinhado-direita">Tempo de Serviço</td>
                                <td class="alinhado-esquerda"><?php echo $tempoServico->format('%Y anos, %m meses') ?></td>
                            </tr>

                        <?php
                        } else {
                            $inicio = new DateTime($admissao);
                            $fim = new DateTime($demissao);
                            $tempoServico = $inicio->diff($fim);

                        ?>

                            <tr>
                                <td class="alinhado-direita">Dedmissão</td>
                                <td class="alinhado-esquerda"><?php echo implode('/', array_reverse(explode('-', $demissao))) ?></td>
                            </tr>
                            <tr>
                                <td class="alinhado-direita">Tempo de Serviço</td>
                                <td class="alinhado-esquerda"><?php echo $tempoServico->format('%Y anos, %m meses') ?></td>
                            </tr>

                        <?php } ?>
                    </table>
&nbsp;
                    <table class="tabela-sem-bordas">
                        <tr>
                            <td class="alinhado-direita">Nome Completo</td>
                            <td class="alinhado-esquerda"> <?php echo $nomeFuncionario ?></td>
                        </tr>

                    </table>

                </div>

                <div class="aniversariantes-nascimento">

                </div>

                <div class="aniversariantes-admissao">

                </div>

            </div>

        </section>

        <footer>
            <div><?php echo $nomeFuncionario . ' - ' . date('d/m/Y - H:i') ?></div>
        </footer>
</body>

</html>