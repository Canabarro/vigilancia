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
    <title>Cadastrar Cidade</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
</head>

<body>
    <header>
        <?php include('comp/menu.php') ?>
    </header>
    <section class="conteudo-pag">
        <div class="container">
            <h3>Cadastrar Cidade</h3>
            <a href="adminPage.php">voltar</a>
            <br><br>
            <form method="POST" action="">

                <label class="form-label" for="nome">Nome da cidade:</label>
                <input class="form-control" type="tetx" name="nome" required><br><br>

                <label class="form-label" for="estado">Estado:</label>
                <select class="form-control" required name="estado" id="">
                    <option selected value="">Selecione</option>
                    <?php
                    $sqlEstado = "SELECT codigo, nome FROM estado";
                    $resultSQLEstado = $mysqli->query($sqlEstado);
                    ?>
                    <?php
                    if ($resultSQLEstado->num_rows > 0) {
                        while ($row = $resultSQLEstado->fetch_assoc()) {
                            $Codigo_Estado = $row['codigo'];
                            $nome = $row['nome'];
                    ?>
                            <option value='<?php echo $Codigo_Estado; ?>'> <?php echo $nome; ?></option>;
                    <?php
                        }
                    } else {
                        echo "<option value=''>Nenhum dado encontrado</option>";
                    }
                    ?>
                </select><br>

                <input class="btn-primary" type="submit" value="Cadastrar">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $nome = $_POST['nome'];
                    $Codigo_Estado = $_POST['estado'];


                    // Preparando a consulta SQL
                    $sql = "INSERT INTO cidade (nome, Codigo_Estado) VALUES ('$nome', '$Codigo_Estado')";

                    // Executando a consulta
                    if ($mysqli->query($sql) === TRUE) {
                        echo "Cidade cadastrada com sucesso.";
                    } else {
                        echo "Erro ao cadastrar a cidade: " . $mysqli->error;
                    }

                    // Fechando a conexão
                    $mysqli->close();
                } ?>
            </form>
        </div>
    </section>
</body>

</html>