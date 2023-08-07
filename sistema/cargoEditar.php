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
    <title>Editar Cadasatro</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section>
        <div class="container">
            <a href="cargoListar.php">voltar</a>
            <form method="POST" action="">

                <?php
                if (isset($_GET['codigo'])) {
                    $codCargo = $_GET['codigo'];

                    // Consulta SQL para recuperar os dados existentes do registro com base no codigo
                    $sqlConsult = "SELECT * FROM cargo WHERE codigo = $codCargo;";
                    $resultConsult = $mysqli->query($sqlConsult);

                    // Verifique se o registro existe
                    if ($resultConsult->num_rows == 1) {
                        $dadoAntigo = $resultConsult->fetch_assoc();

                    // Exiba um formulário com os dados existentes preenchidos
                ?>

                        <h3>Editar cadastro de cargo</h3>
                        <div class="center-formulario">
                            <div class="painel-formulario">
                                <p>Dados do cargo</p><br>

                                <label class="form-label" for="nome">Nome:</label>
                                <input class="form-control" type="text" name="NovoNome" value="<?php echo $dadoAntigo['nome'] ?>" required><br><br>

                                <label class="form-label" for="sigla">Descrição:</label>
                                <textarea class="form-control" name="NovoDescricao" id="" cols="100" rows="10"><?php echo $dadoAntigo['descricao'] ?></textarea>
                               
                        </div>
                        <input class="btn-primary" type="submit" value="Atualizar">

                <?php
                    } else {
                        echo "<br><br><div class=\"alert alert-danger\" role=\"alert\">Registro não encontrado.</div>";
                    }
                } else {
                    echo "<br><br><div class=\"alert alert-danger\" role=\"alert\"> Codigo do registro bão encontrado.</div>";
                }

                //parte de efutação da att

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Receba os dados enviados pelo formulário

                    $NovoNome = $_POST['NovoNome'];
                    $NovoDescricao = $_POST['NovoDescricao'];
   
                    // Valide os dados conforme suas regras de validação



                    // Construa a consulta SQL para atualizar o registro

                    $sql = "UPDATE cargo SET nome = '$NovoNome', descricao = '$NovoDescricao' WHERE codigo = $codCargo";

                    // Execute a consulta SQL para atualizar o registro

                    if ($mysqli->query($sql) === TRUE) {
                        echo "<br><br><div class=\"confirm-alert\" role=\"alert\"> Cadastro atualizado!</div>";
                        header("Refresh: 5");
                    } else {
                        echo "Erro ao atualizar o cadastro: " . $mysqli->error;
                    }
                }
                ?>
            </form>
        </div>
    </section>
</body>

</html>