<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesse sua conta</title>
    <link rel="stylesheet" href="css/all.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <header>

    </header>
    <section class="conteudo-pag">
        <div class="container">
     
            <div class="center-login">
            
                <div class="painel-login">
                    <form action="" method="POST">

                    

                        <label class="form-label" for="username">Usuário</label>
                        <input class="form-control" name="username" type="text"><br><br>

                        <label class="form-label" for="password">Senha</label>
                        <input class="form-control" name="password" type="password"><br>

                      <center>  <button class="btn btn-primary" type="submit">Entrar</button><br>

                        <?php
                        include('conexao.php');

                        if (isset($_POST['username']) || isset($_POST['password'])) {

                            if (strlen($_POST['username']) == 0) {
                                echo "<br><div class=\"alert alert-danger\" role=\"alert\"> Digite seu usuário</div>";
                            } else if (strlen($_POST['password']) == 0) {
                                echo "<br><div class=\"alert alert-danger\" role=\"alert\"> Digite sua senha</div>";
                            } else {

                                $username = $mysqli->real_escape_string($_POST['username']);
                                $password = $mysqli->real_escape_string($_POST['password']);

                                $sql_code = "SELECT * FROM usuario WHERE username = '$username' AND password = '$password'";

                                $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: " . $mysqli->error);

                                $quantidade = $sql_query->num_rows;

                                if ($quantidade == 1) {

                                    $usuario_on = $sql_query->fetch_assoc();

                                    if (!isset($_SESSION)) {
                                        session_start();
                                    }

                                    $_SESSION['codigo'] = $usuario_on['codigo'];
                                    $_SESSION['username'] = $usuario_on['username'];
                                    $_SESSION['nome'] = $usuario_on['_nome'];
                                    $_SESSION['admin'] = $usuario_on['admin'];

                                    header("Location: home.php");
                                } else {
                                    echo "<br><div class=\"alert alert-danger\" role=\"alert\"> Falha ao logar! usuário ou senha incorretos</div>";
                                }
                            }
                        }
                        ?>
                      </center>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- <section>
        <div class="container">
            <div class="center">
                <label for="">Licenciado para:</label>
                <img height="200px" src="img/gestor_icon.png" alt=""><br>
            </div>
        </div>
    </section> -->
    <footer></footer>
</body>

</html>