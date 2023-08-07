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
    <title>Editar cadastro de funcionário</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js"></script>
</head>

<body>
    <section>
        <div class="container">
            <a href="funcListar.php">voltar</a>
            <form method="POST" action="">

                <?php
                if (isset($_GET['codigo'])) {
                    $codUser = $_GET['codigo'];

                    // Consulta SQL para recuperar os dados existentes do registro com base no ID
                    $sqlConsult = "SELECT usuario.codigo, usuario.password, usuario.username, usuario.Codigo_Cargo, usuario.Codigo_Setor, usuario.Codigo_Cidade, usuario.telefone, usuario.cpf, usuario.nome, usuario.email,cargo.nome AS nome_cargo, cidade.nome AS nome_cidade, setor.nome AS nome_setor, usuario.data_admissao, usuario.data_demissao, usuario.admin
                               
                    FROM usuario
                    JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo
                    JOIN cidade ON usuario.Codigo_Cidade = cidade.codigo
                    JOIN setor ON usuario.Codigo_Setor = setor.codigo
                    WHERE usuario.codigo = $codUser;";
                    $resultConsult = $mysqli->query($sqlConsult);

                    // Verifique se o registro existe
                    if ($resultConsult->num_rows == 1) {
                        $dadoAntigo = $resultConsult->fetch_assoc();

                        // Exiba um formulário com os dados existentes preenchidos
                ?>

                        <h3>Editar cadastro de funcionário</h3>
                        <div class="center-formulario">
                            <div class="painel-formulario">
                                <p>Dados do funcionário</p><br>

                                <label class="form-label" for="nome">Nome:</label>
                                <input class="form-control" type="text" name="NovoNome" value="<?php echo $dadoAntigo['nome'] ?>" required><br><br>

                                <label class="form-label" for="cpf">CPF:</label>
                                <input class="form-control" type="text" oninput="formatarCPF(this)" name="NovoCpf" value="<?php echo $dadoAntigo['cpf'] ?>" required><br><br>

                                <label class="form-label" for="telefone">Telefone</label>
                                <input class="form-control" type="text" name="NovoTelefone" value="<?php echo $dadoAntigo['telefone'] ?>" required><br><br>

                                <label class="form-label" for="email">E-mail</label>
                                <input class="form-control" type="email" name="NovoEmail" value="<?php echo $dadoAntigo['email'] ?>"><br><br>


                                <label class="form-label" for="cargo">Cargo:</label>
                                <select class="form-control" required name="NovoCargo" id="">
                                    <?php
                                    $sqlCargo = "SELECT codigo, nome FROM cargo";
                                    $resultSQLCargo = $mysqli->query($sqlCargo);
                                    ?>
                                    <option selected value="<?php echo $dadoAntigo['Codigo_Cargo'] ?>"> <?php echo $dadoAntigo['nome_cargo'] ?> </option>
                                    <?php
                                    if ($resultSQLCargo->num_rows > 0) {
                                        while ($row = $resultSQLCargo->fetch_assoc()) {
                                            $Codigo_Cargo = $row['codigo'];
                                            $nome = $row['nome'];
                                            echo "<option value='$Codigo_Cargo'>$nome</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Nenhum dado encontrado</option>";
                                    }
                                    ?>
                                </select><br><br>

                                <label class="form-label" for="setor">Setor:</label>
                                <select class="form-control" required name="NovoSetor" id="">
                                    <?php
                                    $sqlSetor = "SELECT codigo, nome FROM setor";
                                    $resultSQLSetor = $mysqli->query($sqlSetor);
                                    ?>
                                    <option selected value="<?php echo $dadoAntigo['Codigo_Setor'] ?>"><?php echo $dadoAntigo['nome_setor'] ?></option>

                                    <?php
                                    if ($resultSQLSetor->num_rows > 0) {
                                        while ($row = $resultSQLSetor->fetch_assoc()) {
                                            $Codigo_Setor = $row['codigo'];
                                            $nome = $row['nome'];
                                            echo "<option value='$Codigo_Setor'>$nome</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Nenhum dado encontrado</option>";
                                    }
                                    ?>
                                </select><br><br>

                                <label class="form-label" for="data_admissao">Data de admissão:</label>
                                <input class="form-control" type="date" name="NovoData_admissao" value="<?php echo $dadoAntigo['data_admissao'] ?>" required><br><br>

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
                            <div class="painel-formulario">

                                <p>Dados de acesso</p><br>

                                <label class="form-label" for="username">Username:</label>
                                <input class="form-control" type="text" name="NovoUsername" value="<?php echo $dadoAntigo['username'] ?>" required><br><br>

                                <label class="form-label" for="password">Senha:</label>
                                <input class="form-control" type="password" name="NovoPassword" value="<?php echo $dadoAntigo['password'] ?>" required><br><br>

                                <label class="form-label" for="confirmar_senha">Confirmar Senha:</label>
                                <input class="form-control" type="password" name="NovoConfirmar_senha" value="<?php echo $dadoAntigo['password'] ?>" required><br><br>

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
                    $NovoUsername = $_POST['NovoUsername'];
                    $NovoCpf = $_POST['NovoCpf'];
                    $NovoTelefone = $_POST['NovoTelefone'];
                    $NovoEmail = $_POST['NovoEmail'];
                    $NovoData_admissao = $_POST['NovoData_admissao'];
                    $NovoCidade = $_POST['NovoCidade'];
                    $NovoCargo = $_POST['NovoCargo'];
                    $NovoSetor = $_POST['NovoSetor'];
                    $NovoPassword = $_POST['NovoPassword'];
                    $NovoConfirmar_senha = $_POST['NovoConfirmar_senha'];
                    // Valide os dados conforme suas regras de validação

                    if ($NovoPassword != $NovoConfirmar_senha) {
                        echo "<br><br><div class=\"alert alert-danger\" role=\"alert\"> As senhas não são iguais.</div>";
                        exit();
                    }

                    // Construa a consulta SQL para atualizar o registro

                    $sql = "UPDATE usuario SET nome = '$NovoNome', data_admissao = '$NovoData_admissao', telefone = '$NovoTelefone', username = '$NovoUsername', password = '$NovoPassword', cpf = '$NovoCpf', email = '$NovoEmail', Codigo_Cargo = '$NovoCargo', Codigo_Cidade = '$NovoCidade', Codigo_Setor = '$NovoSetor' WHERE codigo = $codUser";

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