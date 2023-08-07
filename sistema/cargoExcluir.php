<?php
include('conexao.php');
include('protect.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir cadastro de cargo</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section>
        <div class="container">
            <a href="CargoListar.php">voltar</a>
            <form method="POST" action="">

                <?php
                if (isset($_GET['codigo'])) {
                    $codCargo = $_GET['codigo'];

                    // Consulta SQL para recuperar os dados existentes do registro com base no ID
                    $sqlConsult = "SELECT * FROM cargo WHERE codigo = $codCargo;";
                    $resultConsult = $mysqli->query($sqlConsult);

                    // Verifique se o registro existe
                    if ($resultConsult->num_rows == 1) {
                        $dadoAntigo = $resultConsult->fetch_assoc();

                        // Exiba um formulário com os dados existentes preenchidos
                ?>

                        <div class="center-formulario">
                            <div class="painel-formulario">
                                <p>Deseja mesmo exlcuir o cadastro deste cargo?</p><br>
                                <a><?php echo $dadoAntigo['nome'] ?></a><br><br>
                            </div>
                        <input class="btn-primary" type="submit" value="Excluir">
                <?php
                    } else {
                        echo "<br><br><div class=\"alert alert-danger\" role=\"alert\">Registro não encontrado.</div>";
                    }
                } else {
                    echo "<br><br><div class=\"alert alert-danger\" role=\"alert\"> Codigo do registro não encontrado.</div>";
                }

                //parte de efutação da att

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    

                    $sql = "DELETE FROM cargo WHERE codigo = $codCargo";

                    // Execute a consulta SQL para atualizar o registro

                    if ($mysqli->query($sql) === TRUE) {

                        echo "<br><br><div class=\"confirm-alert\" role=\"alert\"> Cadastro deletado!</div>";
                        header("Location: cargoListar.php");
                    } else {
                        echo "Erro ao deletar o cadastro: " . $mysqli->error;
                    }
                }
                ?>
            </form>
        </div>
    </section>
</body>

</html>