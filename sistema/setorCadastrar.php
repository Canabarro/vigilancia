<?php
include('protect.php');
include('conexao.php');
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
    <title>Cadastrar Setor</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <a href="setorListar.php">voltar</a>
    <br>
    <h3>Cadastrar Setor</h3>
    <br>
    <form method="POST" action="">

        <div class="container">
            <div class="">
                <div class="painel-center">
                    <label class="form-label" for="nome">Nome do setor:</label>
                    <input class="form-control" ctype="text" name="nome" required><br><br>

                    <label class="form-label" for="descricao">Descrição:</label>
                    <textarea class="form-control" name="descricao" id="" cols="30" rows="10"></textarea><br>

                    <input class="btn-primary" type="submit" value="Cadastrar">
                </div>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $nome = $_POST['nome'];
                    $descricao = $_POST['descricao'];

                    // Verificar se o nome do cargo já existe no banco de dados
                    $checkQuery = "SELECT * FROM setor WHERE nome = '$nome'";
                    $checkResult = $mysqli->query($checkQuery);

                    if ($checkResult->num_rows > 0) {
                        echo "<br><div class=\"alert-danger\" role=\"alert\"> Já existe um cargo cadastrado com este nome!</div>";
                    } else {
                        // Preparando a consulta SQL
                        $sql = "INSERT INTO setor (nome, descricao) VALUES ('$nome', '$descricao')";

                        // Executando a consulta
                        if ($mysqli->query($sql) === TRUE) {
                            echo "<br><div class=\"confirm-alert\" role=\"alert\"> Cadastro realizado com sucesso!</div>";
                        } else {
                            echo "Erro ao cadastrar o setor: " . $mysqli->error;
                        }
                    }

                    // Fechando a conexão
                    $mysqli->close();
                } ?>

            </div>
        </div>
    </form>
</body>

</html>