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
    <title>Editar cadastro de Cliente</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js"></script>
</head>

<body>
    <section class="conteudo-pag">
        <div class="container">
            <a href="clienteListar.php">voltar</a>
            <form method="POST" action="">

                <?php
                if (isset($_GET['codigo'])) {
                    $codigo = $_GET['codigo'];

                    // Consulta SQL para recuperar os dados existentes do registro com base no ID
                    $sqlConsult = "SELECT cliente.codigo, cliente.Codigo_Cidade, cliente.telefone, cliente.cnpj, cliente.nome, cliente.email, cidade.nome AS nome_cidade
                    FROM cliente
                    JOIN cidade ON cliente.Codigo_Cidade = cidade.codigo
                    WHERE cliente.codigo = $codigo;";
                    $resultConsult = $mysqli->query($sqlConsult);

                    // Verifique se o registro existe
                    if ($resultConsult->num_rows == 1) {
                        $dadoAntigo = $resultConsult->fetch_assoc();

                        // Exiba um formulário com os dados existentes preenchidos
                ?>
                        <div class="center-formulario">
                            <div class="painel-formulario">
                                <p>Dados do Cliente</p><br>

                                <label class="form-label" for="nome">Nome:</label>
                                <input class="form-control" type="text" name="NovoNome" value="<?php echo $dadoAntigo['nome'] ?>" required><br><br>

                                <label class="form-label" for="cpf">CNPJ:</label>
                                <input class="form-control" type="text" oninput="formatarCNPJ(this)" name="NovoCnpj" value="<?php echo $dadoAntigo['cnpj'] ?>" required><br><br>

                                <label class="form-label" for="telefone">Telefone</label>
                                <input class="form-control" type="text" name="NovoTelefone" value="<?php echo $dadoAntigo['telefone'] ?>" required><br><br>

                                <label class="form-label" for="email">E-mail</label>
                                <input class="form-control" type="email" name="NovoEmail" value="<?php echo $dadoAntigo['email'] ?>"><br><br>

                                <label class="form-label" for="cidade">Cidade:</label>
                                <select class="form-control" required name="NovoCidade" id="">
                                    <?php
                                    $sqlCidade = "SELECT cidade.codigo ,cidade.nome, estado.sigla AS sigla_estado FROM cidade 
                            JOIN estado ON cidade.Codigo_Estado = estado.codigo;";
                                    $resultSQLCidade = $mysqli->query($sqlCidade);
                                    ?>
                                    <option selected value="<?php echo $dadoAntigo['Codigo_Cidade'] ?>"><?php echo $dadoAntigo['nome_cidade'] ?></option>
                                    <?php
                                    if ($resultSQLSetor->num_rows > 0) {
                                        while ($row = $resultSQLCidade->fetch_assoc()) {
                                            $Codigo_Cidade = $row['codigo'];
                                            $nome = $row['nome'];
                                            $sigla = $row['sigla_estado']
                                    ?>
                                            <option value='<?php echo $Codigo_Cidade; ?>'> <?php echo $nome . " - " . $sigla;  ?></option>;
                                    <?php
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
                    $NovoCnpj = $_POST['NovoCnpj'];
                    $NovoTelefone = $_POST['NovoTelefone'];
                    $NovoEmail = $_POST['NovoEmail'];
                    $NovoCidade = $_POST['NovoCidade'];

                    // Valide os dados conforme suas regras de validação
                    $sqlCnpj = "SELECT * FROM cliente WHERE cnpj = '$NovoCnpj'";
                    $resultCnpj = $mysqli->query($sqlCnpj);

                    if ($resultCnpj->num_rows > 0) {
                        // Já existe outra unidade com o CNPJ fornecido
                        echo "<br><br><div class=\"alert-danger\" role=\"alert\"> Já existe um cadastro com o CNPJ fornecido!</div>";
                        exit();
                    }
                    // Construa a consulta SQL para atualizar o registro

                    $sql = "UPDATE cliente SET nome = '$NovoNome', telefone = '$NovoTelefone', cnpj = '$NovoCnpj', email = '$NovoEmail', Codigo_Cidade = '$NovoCidade' WHERE codigo = $codigo";

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