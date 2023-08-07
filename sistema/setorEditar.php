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
    <title>Editar cadastro de setor</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section>
        <div class="container">
            <a href="setorListar.php">voltar</a>
            <form method="POST" action="">

                <?php
                if (isset($_GET['codigo'])) {
                    $codSetor = $_GET['codigo'];

                    // Consulta SQL para recuperar os dados existentes do registro com base no ID
                    $sqlConsult = "SELECT * FROM setor WHERE codigo = $codSetor;";
                    $resultConsult = $mysqli->query($sqlConsult);

                    // Verifique se o registro existe
                    if ($resultConsult->num_rows == 1) {
                        $dadoAntigo = $resultConsult->fetch_assoc();

                        // Exiba um formulário com os dados existentes preenchidos
                ?>

                        <h3>Editar cadastro de setor</h3>
                        <div class="center-formulario">
                            <div class="painel-formulario">
                                <p>Dados do setor</p><br>

                                <label class="form-label" for="nome">Nome:</label>
                                <input class="form-control" type="text" name="NovoNome" value="<?php echo $dadoAntigo['nome'] ?>" required><br><br>

                             <!--   <label class="form-label" for="sigla">Unidade:</label>
                               <input class="form-control" type="text" name="NovoSigla" value="" required><br><br> -->

                               

                        </div>
                        <input class="btn-primary" type="submit" value="Atualizar">

                <?php
                    } else {
                        echo "<br><br><div class=\"alert alert-danger\" role=\"alert\">Registro não encontrado.</div>";
                    }
                } else {
                    echo "<br><br><div class=\"alert alert-danger\" role=\"alert\"> Codigo do registro não encontrado.</div>";
                }

                //parte de efutação da att

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    // Receba os dados enviados pelo formulário

                    $NovoNome = $_POST['NovoNome'];
                   // $NovoUnidade = $_POST['NovoUnidade'];
   
                    // Valide os dados conforme suas regras de validação



                    // Construa a consulta SQL para atualizar o registro

                    $sql = "UPDATE setor SET nome = '$NovoNome' WHERE codigo = $codSetor";

                    // Execute a consulta SQL para atualizar o registro

                    if ($mysqli->query($sql) === TRUE) {
                        echo "<br><br><div class=\"confirm-alert\" role=\"alert\"> Cadastro atualizado!</div>";
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