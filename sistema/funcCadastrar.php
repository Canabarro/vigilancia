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
    <title>Cadastrar funcionário</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/scripts.js"></script>
</head>

<body>
    <section>
        <div class="container">
            <a href="funcListar.php">voltar</a>
            <form method="POST" action="">
                <h3>Cadastrar Funcionário</h3>
                <div class="center-formulario">
                    <div class="painel-formulario">
                        <p>Dados do funcionário</p><br>

                        <label class="form-label" for="nome">Nome *</label>
                        <input class="form-control" type="text" name="nome" required><br><br>

                        <label class="form-label" for="cpf">CPF *</label>
                        <input class="form-control" type="text" oninput="formatarCPF(this)" name="cpf" placeholder="somente números" required><br><br>

                        <label class="form-label" for="genero">Gênero *</label>
                        <label class="form-label">
                            <input type="radio" name="genero" value="f">
                            Feminino
                        </label>

                        <label class="form-label" for="genero">
                            <input type="radio" name="genero" value="m">
                            Masculino
                        </label><br>

                        <label class="form-label" for="data_nascimento">Data de Nascimento</label>
                        <input class="form-control" type="date" name="data_nascimento"><br><br>

                        <label class="form-label" for="telefone">Telefone *</label>
                        <input class="form-control" type="text" name="telefone" required><br><br>

                        <label class="form-label" for="email">E-mail</label>
                        <input class="form-control" type="email" name="email"><br><br>


                        <label class="form-label" for="cargo">Cargo *</label>
                        <select class="form-control" required name="cargo" id="">
                            <option selected value="">selecione</option>
                            <?php
                            $sqlCargo = "SELECT codigo, nome FROM cargo";
                            $resultSQLCargo = $mysqli->query($sqlCargo);
                            ?>
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

                        <label class="form-label" for="setor">Setor *</label>
                        <select class="form-control" required name="setor" id="">
                            <option selected value="">selecione</option>
                            <?php
                            $sqlSetor = "SELECT codigo, nome FROM setor";
                            $resultSQLSetor = $mysqli->query($sqlSetor);
                            ?>
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

                        <label class="form-label" for="data_admissao">Data de admissão *</label>
                        <input class="form-control" type="date" name="data_admissao" required><br><br>

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
                        </select>

                        <label class="form-label" for="unidade">Unidade</label>
                        <select class="form-control" name="unidade" id="">
                            <option selected value="">selecione</option>
                            <?php

                            $sqlUN = "SELECT unidade.codigo, unidade.Codigo_Cidade_UN, unidade.nome, cidade.nome AS cidade_nome, estado.sigla AS estado_sigla FROM unidade 
                           JOIN cidade ON unidade.Codigo_Cidade_UN = cidade.codigo
                           JOIN estado ON cidade.Codigo_Estado = estado.codigo";
                            $resultSQLUN = $mysqli->query($sqlUN);

                            ?>

                            <?php
                            if ($resultSQLUN->num_rows > 0) {
                                while ($row = $resultSQLUN->fetch_assoc()) {
                                    $Codigo_UN = $row['codigo'];
                                    $nome = $row['nome'];
                                    $cidade = $row['cidade_nome'];
                                    $sigla = $row['estado_sigla'];

                            ?>
                                    <option value='<?php echo $Codigo_UN; ?>'> <?php echo "($Codigo_UN) $nome - $cidade/$sigla "; ?></option>;
                            <?php
                                }
                            } else {
                                echo "<option value=''>Nenhum dado encontrado</option>";
                            }
                            ?>
                        </select>

                        <br><br>
                    </div>
                    <div class="painel-formulario">

                        <p>Dados de acesso</p><br>

                        <label class="form-label" for="username">Username *</label>
                        <input class="form-control" type="text" name="username" required><br><br>

                        <label class="form-label" for="password">Senha *</label>
                        <input class="form-control" type="password" name="password" required><br><br>

                        <label class="form-label" for="confirmar_senha">Confirmar Senha *</label>
                        <input class="form-control" type="password" name="confirmar_senha" required><br><br>

                    </div>
                </div>
                <input class="btn-primary" type="submit" value="Cadastrar">

                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $nome = $_POST['nome'];
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $confirmarSenha = $_POST['confirmar_senha'];

                    $Codigo_Cidade = $_POST['cidade'];
                    $Codigo_Cargo = $_POST['cargo'];
                    $Codigo_Setor = $_POST['setor'];

                    $data_admissao = $_POST['data_admissao'];
                    $data_nascimento = $_POST['data_nascimento'];
                    $genero = $_POST['genero'];
                    $cpf = $_POST['cpf'];
                    $telefone = $_POST['telefone'];
                    $email = $_POST['email'];
                    $unidade = $_POST['unidade'];

                    // Verificando se as senhas coincidem
                    if ($password !== $confirmarSenha) {
                        echo "As senhas não coincidem.";
                        exit;
                    }
                    if (!$email) {
                        $email = null;
                    }
                    $sqlCpf = "SELECT * FROM usuario WHERE cpf = '$cpf'";
                    $resultCpf = $mysqli->query($sqlCpf);

                    if ($resultCpf->num_rows > 0) {
                        // Já existe outra unidade com o CNPJ fornecido
                        echo "Erro: Já existe outra pessoa cadastrada com o CPF fornecido.";
                        exit();
                    }
                    $sqlUsername = "SELECT * FROM usuario WHERE username = '$username'";
                    $resultUser = $mysqli->query($sqlUsername);

                    if ($resultUser->num_rows > 0) {
                        // Já existe outra unidade com o CNPJ fornecido
                        echo "Erro: Já existe outra pesso cadastrada com o username fornecido.";
                        exit();
                    }
                    // Preparando a consulta SQL
                    $sql = "INSERT INTO usuario (username, password, email, telefone, nome, cpf, genero, data_nascimento, data_admissao, Codigo_Unidade, Codigo_Cidade, Codigo_Cargo, Codigo_Setor) VALUES ('$username', '$password', '$email', '$telefone', '$nome', '$cpf', '$genero', '$data_nascimento', '$data_admissao', '$unidade', '$Codigo_Cidade', '$Codigo_Cargo', '$Codigo_Setor')";

                    // Executando a consulta
                    if ($mysqli->query($sql) === TRUE) {
                        echo "Usuário cadastrado com sucesso.";
                    } else {
                        echo "Erro ao cadastrar o usuário: " . $mysqli->error;
                    }
                    // Fechando a conexão
                    $mysqli->close();
                } ?>
            </form>
        </div>
    </section>
</body>

</html>