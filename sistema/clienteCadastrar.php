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
    <title>Cadastrar Cliente</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js"></script>
</head>

<body>
    <section>
        <div class="container">
            <form method="POST" action="">
                <h3>Cadastrar Cliente</h3> <a href="clienteListar.php">voltar</a>
                <div class="center-formulario">
                    <div class="painel-formulario">
                        <label class="form-label" for="nome">Nome *</label>
                        <input class="form-control" type="text" name="nome" required><br><br>

                        <label class="form-label" for="cnpj">CNPJ *</label>
                        <input class="form-control" type="text" name="cnpj" oninput="formatarCNPJ(this)" placeholder="somente números" required><br><br>

                        <script>

                        </script>

                        <label class="form-label" for="telefone">Telefone *</label>
                        <input class="form-control" type="text" name="telefone" required><br><br>

                        <label class="form-label" for="email">E-mail</label>
                        <input class="form-control" type="email" name="email"><br><br>

                        <label class="form-label" for="cidade">Cidade *</label>
                        <select class="form-control" required name="cidade" id="">
                            <option selected value="">selecione</option>
                            <?php
                            $sqlCidade = "SELECT cidade.codigo, cidade.nome, estado.sigla AS sigla_estado FROM cidade 
                            JOIN estado ON cidade.Codigo_Estado = estado.codigo;";
                            $resultSQLCidade = $mysqli->query($sqlCidade);
                            ?>
                            <?php
                            if ($resultSQLCidade->num_rows > 0) {
                                while ($row = $resultSQLCidade->fetch_assoc()) {
                                    $Codigo_Cidade = $row['codigo'];
                                    $nome = $row['nome'];
                                    $sigla = $row['sigla_estado']
                            ?>
                                    <option value='<?php echo $Codigo_Cidade ?>'> <?php echo $nome . " - " . $sigla;  ?></option>;
                            <?php
                                }
                            } else {
                                echo "<option value=''>Nenhum dado encontrado</option>";
                            }
                            ?>
                        </select><br><br>
                    </div>
           
                </div>
                <input class="btn-primary" type="submit" value="Cadastrar">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $nome = $_POST['nome'];
                    $Codigo_Cidade = $_POST['cidade'];
                    $cnpj = $_POST['cnpj'];
                    $telefone = $_POST['telefone'];
                    $email = $_POST['email'];

                    // Verificando se as senhas coincidem

                    $sqlCnpj = "SELECT * FROM cliente WHERE cnpj = '$cnpj'";
                    $resultCnpj = $mysqli->query($sqlCnpj);

                    if ($resultCnpj->num_rows > 0) {
                        // Já existe outra unidade com o CNPJ fornecido
                        echo "<br><br><div class=\"alert-danger\" role=\"alert\"> Já existe um cadastro com o CNPJ fornecido!</div>";
                        exit();
                    }

                    // Preparando a consulta SQL
                    $sql = "INSERT INTO cliente (nome, email, telefone, cnpj, Codigo_Cidade) VALUES ('$nome', '$email', '$telefone', '$cnpj', '$Codigo_Cidade')";

                    // Executando a consulta
                    if ($mysqli->query($sql) === TRUE) {
                        echo "<br><br><div class=\"confirm-alert\" role=\"alert\"> Cadastro realizado com sucesso!.</div>";
                    } else {
                        echo "Erro ao realizar cadastro: " . $mysqli->error;
                    }
                    // Fechando a conexão
                    $mysqli->close();
                } ?>
            </form>
        </div>
    </section>
</body>

</html>