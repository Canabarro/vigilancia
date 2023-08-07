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
    <title>Editar cadastro de cidade</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section>
        <div class="container">
            <a href="cidadeListar.php">voltar</a>
            <form method="POST" action="">

                <?php
                if (isset($_GET['codigo'])) {
                    $codCidade = $_GET['codigo'];

                    // Consulta SQL para recuperar os dados existentes do registro com base no ID
                    $sqlConsult = "SELECT cidade.codigo, cidade.nome, cidade.Codigo_Estado, estado.nome AS nome_estado, estado.sigla AS sigla_estado
                    FROM cidade
                    JOIN estado ON cidade.Codigo_Estado = estado.codigo
                    WHERE cidade.codigo = $codCidade;";
                    $resultConsult = $mysqli->query($sqlConsult);

                    // Verifique se o registro existe
                    if ($resultConsult->num_rows == 1) {
                        $dadoAntigo = $resultConsult->fetch_assoc();

                        // Exiba um formulário com os dados existentes preenchidos
                ?>
                        <h3>Editar cadastro de cidade</h3>
                        <div class="center-formulario">
                            <div class="painel-formulario">
                                <p>Dados da cidade</p><br>

                                <label class="form-label" for="NovoNome">Nome:</label>
                                <input class="form-control" type="text" name="NovoNome" value="<?php echo $dadoAntigo['nome'] ?>" required><br><br>

                                <label class="form-label" for="NovoEstado">Estado:</label>
                                <select class="form-control" required name="NovoEstado" id="">
                                    <?php
                                    $sql = "SELECT codigo, nome, sigla FROM estado";
                                    $resultSQL = $mysqli->query($sql);
                                    ?>
                                    <option selected value="<?php echo $dadoAntigo['Codigo_Estado'] ?>"> <?php echo $dadoAntigo['nome_estado'] ?> </option>
                                    <?php
                                    if ($resultSQL->num_rows > 0) {
                                        while ($row = $resultSQL->fetch_assoc()) {
                                            $Codigo_Estado = $row['codigo'];
                                            $nome = $row['nome'];
                                            echo "<option value='$Codigo_Estado'>$nome</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Nenhum dado encontrado</option>";
                                    }
                                    ?>
                                </select><br><br>
                            </div>

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
                    $NovoEstado = $_POST['NovoEstado'];
                    // Valide os dados conforme suas regras de validação

      

                    // Construa a consulta SQL para atualizar o registro

                    $sql = "UPDATE cidade SET nome = '$NovoNome', Codigo_Estado = '$NovoEstado' WHERE codigo = $codCidade";

                    // Execute a consulta SQL para atualizar o registro

                    if ($mysqli->query($sql) === TRUE) {
                        echo "<br><br><div class=\"confirm-alert\" role=\"alert\"> Cadastro atualizado!.</div>";
                    } else {
                        echo "Erro ao atualizar o registro: " . $mysqli->error;
                    }
                }
                ?>

            </form>
        </div>
    </section>
</body>

</html>