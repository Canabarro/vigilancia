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

    <section class="conteudo-pag">
        <div class="container">
            <a href="unidadeListar.php">voltar</a>
            <form method="POST" action="">
                <?php
                if (isset($_GET['codigo'])) {
                    $codigo = $_GET['codigo'];

                    // Consulta SQL para recuperar os dados existentes do registro com base no ID
                    $sqlConsult = "SELECT unidade.codigo, unidade.nome, unidade.cnpj, unidade.descricao, unidade.endereco, unidade.Codigo_Cidade_UN, unidade.Codigo_Responsavel, unidade.email, unidade.telefone, unidade.data_fundacao, unidade.endereco, cidade.nome AS nome_cidade, usuario.nome AS nome_usuario, cargo.nome AS nome_cargo
                    FROM unidade
                    JOIN usuario ON unidade.Codigo_Responsavel = usuario.codigo
                    JOIN cidade ON unidade.Codigo_Cidade_UN = cidade.codigo
                    JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo
                    
                    WHERE unidade.codigo = $codigo;";
                    $resultConsult = $mysqli->query($sqlConsult);

                    // Verifique se o registro existe
                    if ($resultConsult->num_rows == 1) {
                        $dadoAntigo = $resultConsult->fetch_assoc();

                        // Exiba um formulário com os dados existentes preenchidos
                ?>
                        <div class="container">
                            <h3>Editar cadastro de unidade</h3>
                            <input class="btn-primary" type="submit" value="Atualizar">
                            <div class="center-formulario">
                                <div class="painel-formulario">

                                    <label class="form-label" for="nome">Nome:</label>
                                    <input class="form-control" type="text" name="NovoNome" value="<?php echo $dadoAntigo['nome'] ?>" required><br>

                                    <label class="form-label" for="cpf">CNPJ:</label>
                                    <input class="form-control" type="text" oninput="formatarCNPJ(this)" name="NovoCnpj" value="<?php echo $dadoAntigo['cnpj'] ?>" required><br>

                                    <label class="form-label" for="telefone">Telefone</label>
                                    <input class="form-control" type="text" name="NovoTelefone" value="<?php echo $dadoAntigo['telefone'] ?>" required><br>

                                    <label class="form-label" for="email">E-mail</label>
                                    <input class="form-control" type="email" name="NovoEmail" value="<?php echo $dadoAntigo['email'] ?>"><br>

                                    <label class="form-label" for="NovoResponsavel">Funcionário Responsável:</label>
                                    <select class="form-control" required name="NovoResponsavel" id="" required>
                                        <?php
                                        $sqlUsuario = "SELECT usuario.codigo, usuario.nome, cargo.nome AS cargo_nome FROM usuario
                                    JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo;";
                                        $resultSQLUsuario = $mysqli->query($sqlUsuario);
                                        ?>
                                        <option selected value="<?php echo $dadoAntigo['Codigo_Responsavel'] ?>"> <?php echo $dadoAntigo['nome_usuario'] . " - " . $dadoAntigo['nome_cargo'] ?> </option>
                                        <?php
                                        if ($resultSQLUsuario->num_rows > 0) {
                                            while ($row = $resultSQLUsuario->fetch_assoc()) {
                                                $Codigo_Responsavel = $row['codigo'];
                                                $nome = $row['nome'];
                                                $cargo = $row['cargo_nome'];
                                                echo "<option value='$Codigo_Responsavel'>$nome - $cargo</option>";
                                            }
                                        } else {
                                            echo "<option value=''>Nenhum dado encontrado</option>";
                                        }
                                        ?>
                                    </select><br>
                                </div>
                                <div class="painel-formulario">

                                    <label class="form-label" for="data_admissao">Data de Fundação:</label>
                                    <input class="form-control" type="date" name="NovoDataFundacao" value="<?php echo $dadoAntigo['data_fundacao'] ?>" required><br>

                                    <label class="form-label" for="cidade">Cidade:</label>
                                    <select class="form-control" required name="NovoCidade" id="">
                                        <?php
                                        $sqlCidade = "SELECT cidade.codigo, cidade.nome, estado.sigla AS sigla_estado FROM cidade
                                    JOIN estado ON cidade.Codigo_Estado = estado.codigo;";
                                        $resultSQLCidade = $mysqli->query($sqlCidade);
                                        ?>
                                        <option selected value="<?php echo $dadoAntigo['Codigo_Cidade_UN'] ?>"><?php echo $dadoAntigo['nome_cidade'] ?></option>
                                        <?php
                                        if ($resultSQLCidade->num_rows > 0) {
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
                                    </select><br>
                                    <label class="form-label" for="NovoDescricao">Descrição</label>
                                    <textarea class="form-control" name="NovoDescricao" id="" cols="30" rows="10"><?php echo $dadoAntigo['descricao'] ?></textarea>
                                    
                                    <label class="form-label" for="NovoEndereco">Endereço</label>
                                    <input class="form-control" type="text" name="NovoEndereco" value="<?php echo $dadoAntigo['endereco'] ?>">



                                </div>
                            </div>


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
                    $NovoCidade = $_POST['NovoCidade'];
                    $NovoTelefone = $_POST['NovoTelefone'];
                    $NovoEmail = $_POST['NovoEmail'];
                    $NovoDataFundacao = $_POST['NovoDataFundacao'];
                    $NovoResponsavel = $_POST['NovoResponsavel'];
                    $NovoDescricao = $_POST['NovoDescricao'];
                    $NovoEndereco = $_POST['NovoEndereco'];

                    // Valide os dados conforme suas regras de validação

                    // Construa a consulta SQL para atualizar o registro

                    $sql = "UPDATE unidade SET nome = '$NovoNome', data_Fundacao = '$NovoDataFundacao', telefone = '$NovoTelefone', cnpj = '$NovoCnpj', email = '$NovoEmail', Codigo_Responsavel = '$NovoResponsavel', Codigo_Cidade_UN = '$NovoCidade', descricao = '$NovoDescricao', endereco = '$NovoEndereco' WHERE codigo = $codigo";

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
        </div>
    </section>
</body>

</html>