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
    <title>Cadastrar Posto</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js"></script>
</head>

<body>
    <section>
        <div class="container">
            <form method="POST" action="">
                <h3>Cadastrar Posto</h3> <a href="postoListar.php">voltar</a>
                <div class="center-formulario">
                    <div class="painel-formulario">
                        <label class="form-label" for="nome">Nome *</label>
                        <input class="form-control" type="text" name="nome" required><br><br>

                        <label class="form-label" for="endereco">Endereço *</label>
                        <input class="form-control" type="text" name="endereco" required><br><br>

                        <label class="form-label" for="descricao">Descrição </label>
                        <textarea class="form-control" name="descricao" id="" cols="30" rows="10"></textarea>

                        <label class="form-label" for="atuacao">Data de inicio de atuação *</label>
                        <input class="form-control" type="text" name="atuacao" required><br><br>

                        <label class="form-label" for="cidade">Cliente *</label>
                        <select class="form-control" required name="cliente" id="">
                            <option selected value="">selecione</option>
                            <?php
                            $sqlCliente = "SELECT * FROM cliente";

                            $resultSQLCliente = $mysqli->query($sqlCliente);
                            ?>
                            <?php
                            if ($resultSQLCliente->num_rows > 0) {
                                while ($row = $resultSQLCliente->fetch_assoc()) {
                                    $Codigo_Cliente = $row['codigo'];
                                    $nome = $row['nome'];
                                    $cnpj = $row['cnpj']
                            ?>
                                    <option value='<?php echo $Codigo_Cliente ?>'> <?php echo $nome . " - " . $cnpj;  ?></option>;
                            <?php
                                }
                            } else {
                                echo "<option value=''>Nenhum dado encontrado</option>";
                            }
                            ?>
                        </select><br><br>

                        <label class="form-label" for="cidade">Cidade *</label>
                        <select class="form-control" required name="cidade" id="">
                            <option selected value="">selecione</option>
                            <?php
                            $sqlCidade = "SELECT cidade.codigo, cidade.nome, estado.sigla AS estado_sigla FROM cidade
                            join estado ON cidade.Codigo_Estado = estado.codigo";

                            $resultSQLCidade = $mysqli->query($sqlCidade);
                            ?>
                            <?php
                            if ($resultSQLCidade->num_rows > 0) {
                                while ($row = $resultSQLCidade->fetch_assoc()) {
                                    $Codigo_Cidade = $row['codigo'];
                                    $nome = $row['nome'];
                                    $sigla = $row['estado_sigla']
                            ?>
                                    <option value='<?php echo $Codigo_Cidade ?>'> <?php echo $nome . " - " . $sigla;  ?></option>;
                            <?php
                                }
                            } else {
                                echo "<option value=''>Nenhum dado encontrado</option>";
                            }
                            ?>
                        </select><br><br>

                        <label class="form-label" for="unidade">Unidade *</label>
                        <select class="form-control" required name="unidade" id="">
                            <option selected value="">selecione</option>
                            <?php
                            $sqlUnidade = "SELECT unidade.codigo, unidade.nome, unidade.Codigo_Cidade_UN, cidade.nome AS cidade_nome, estado.sigla AS estado_sigla FROM unidade
                            JOIN estado ON cidade.Codigo_Estado = estado.codigo
                            JOIN cidade ON unidade.Codigo_Cidade_UN = cidade.codigo;";

                            $resultSQLUnidade = $mysqli->query($sqlUnidade);
                            ?>
                            <?php
                            if ($resultSQLUnidade->num_rows > 0) {
                                while ($row = $resultSQLUnidade->fetch_assoc()) {
                                    $Codigo_Unidade = $row['codigo'];
                                    $nome = $row['nome'];
                                    $sigla = $row['estado_sigla'];
                                    $cidade = $row['cidade_nome'];
                            ?>
                                    <option value='<?php echo $Codigo_Unidade ?>'> <?php echo $nome . " - " ."(" . $cidade ." - ".$sigla . ")"; ?></option>;
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
                    $

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