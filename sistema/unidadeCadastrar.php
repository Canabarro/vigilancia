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
    <title>Cadastrar unidade</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section>
        <div class="container">
            <a href="unidadeListar.php">voltar</a>
            <form method="POST" action="">
                <h3>Cadastrar Unidade</h3>
                <div class="center-formulario">
                    <div class="painel-formulario">

                        <label class="form-label" for="nome">Nome *</label>
                        <input class="form-control" type="text" name="nome" required><br><br>

                        <label class="form-label" for="cnpj">CNPJ *</label>
                        <input class="form-control" type="text" name="cnpj" required><br><br>

                        <label class="form-label" for="telefone">Telefone *</label>
                        <input class="form-control" type="text" name="telefone" required><br><br>

                        <label class="form-label" for="email">E-mail *</label>
                        <input class="form-control" type="email" name="email" required><br><br>


                        <label class="form-label" for="func_resp">Funcionário Responsável *</label>
                        <select class="form-control" required name="func_resp" id="">
                            <option selected value="">selecione</option>
                            <?php
                            $sqlResp = "SELECT usuario.codigo, usuario.nome, cargo.nome AS cargo_nome FROM usuario 
                            JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo;";
                            $resultSQLResp = $mysqli->query($sqlResp);
                            ?>
                            <?php
                            if ($resultSQLResp->num_rows > 0) {
                                while ($row = $resultSQLResp->fetch_assoc()) {
                                    $Codigo_Resp = $row['codigo'];
                                    $nome = $row['nome'];
                                    $cargo = $row['cargo_nome']
                            ?>
                                    <option value='<?php echo $Codigo_Resp ?>'> <?php echo $nome . " - " . $cargo;  ?></option>;
                            <?php
                                }
                            } else {
                                echo "<option value=''>Nenhum dado encontrado</option>";
                            }
                            ?>
                        </select><br><br>

                    </div>
                    <div class="painel-formulario">

                        <label class="form-label" for="data_admissao">Data de Fundação *</label>
                        <input class="form-control" type="date" name="data_fundacao" required><br><br>

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
                        </select><br>
                        <label class="form-label" for="endereco">Endereço</label>
                        <input class="form-control" type="text" name="endereco">
                        <label class="form-label" for="cidade">Descrição</label>
                        <textarea class="form-control" name="descricao" id="" cols="50" rows="10"></textarea>
                
                    </div>
  
                </div>
                <input class="btn-primary" type="submit" value="Cadastrar">

                <?php
            
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    
                    
                    $nome = $_POST['nome'];

                    $Codigo_Cidade = $_POST['cidade'];
                    $func_resp = $_POST['func_resp'];
                    $descricao = $_POST['descricao'];
                    $data_fundacao = $_POST['data_fundacao'];
                    $cnpj = $_POST['cnpj'];
                    $telefone = $_POST['telefone'];
                    $email = $_POST['email'];
                    $endereco = $_POST['endereco'];
       

                    // Verificar se já existe outra unidade com o CNPJ fornecido
                    $sqlCnpj = "SELECT * FROM unidade WHERE cnpj = '$cnpj'";
                    $resultCnpj = $mysqli->query($sqlCnpj);
                    
                    if ($resultCnpj->num_rows > 0) {
                        // Já existe outra unidade com o CNPJ fornecido
                        echo "Erro: Já existe outra unidade com o CNPJ fornecido.";
                        exit();
                    }
                    // Preparando a consulta SQL
                    $sql = "INSERT INTO unidade (nome, endereco, cnpj, email, descricao, telefone, data_fundacao, Codigo_Cidade_UN, Codigo_Responsavel) VALUES ('$nome', '$endereco', '$cnpj', '$email', '$descricao', '$telefone', '$data_fundacao', '$Codigo_Cidade', '$func_resp')";

                    // Executando a consulta
                    if ($mysqli->query($sql) === TRUE) {
                        echo "<br><br><div class=\"confirm-alert\" role=\"alert\"> Cadastro realizado com sucesso!</div>";
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