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
    <title>Cadastrar Estado</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
</head>

<body>
    <header>
        <?php include('comp/menu.php') ?>
    </header>
    <section class="conteudo-pag">
        <div class="container">
            <a href="estadoListar.php">voltar</a>
            <br>
            <h3>Cadastrar Estado</h3>
            <br>
            <form method="POST" action="">
                <label class="form-label" for="nome">Nome do estado:</label>
                <input class="form-control" type="tetx" name="nome" required><br><br>

                <label class="form-label" for="sigla">Sigla:</label>
                <input class="form-control" type="tetx" name="sigla" required><br><br>


                <input class="btn-primary" type="submit" value="Cadastrar">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $nome = $_POST['nome'];
                    $sigla = $_POST['sigla'];


                    // Preparando a consulta SQL
                    $sql = "INSERT INTO estado (nome, sigla) VALUES ('$nome', '$sigla')";

                    // Executando a consulta
                    if ($mysqli->query($sql) === TRUE) {
                        echo "Estado cadastrado com sucesso.";
                    } else {
                        echo "Erro ao cadastrar estado: " . $mysqli->error;
                    }

                    // Fechando a conexão
                    $mysqli->close();
                } ?>
            </form>
        </div>
    </section>
</body>

</html>