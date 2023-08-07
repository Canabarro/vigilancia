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
    <title>administrador</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/menu.css">
</head>
<?php include('comp/menu.php'); ?>

<body>
    <header>
    </header>
    <section class="conteudo-pag">
        <div class="container">
            <?php 
            $userCod = $_SESSION['codigo'];

            $adminDados = "SELECT * FROM usuario WHERE codigo = $userCod;";
            
            $sql_query = $mysqli->query($adminDados) or die("Falha na execução do código SQL: " . $mysqli->error);
            if ($sql_query->num_rows > 0) {
                // Recupera os dados do usuário
                $row = $sql_query->fetch_assoc();
                $nomeFuncionario = $row['nome'];
                
             ?>
            <h1>Seja bem vind(a) <?php echo $nomeFuncionario;
            }?> </h1>
            <h4>Você está acessando a página de <a style="color: green;">administrador</a>.</h4>
        </div>
    </section>

    <script src="js/scripts.js"></script>
</body>

</html>