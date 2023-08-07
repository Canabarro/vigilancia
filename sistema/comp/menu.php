

<?php
$userCod = $_SESSION['codigo'];
$query = "SELECT usuario.nome, usuario.username, cargo.nome AS nome_cargo, cidade.nome AS nome_cidade, setor.nome AS nome_setor, usuario.data_admissao, usuario.data_demissao, usuario.admin
    FROM usuario
    JOIN cargo ON usuario.Codigo_Cargo = cargo.codigo
    JOIN cidade ON usuario.Codigo_Cidade = cidade.codigo
    JOIN setor ON usuario.Codigo_Setor = setor.codigo
    WHERE usuario.codigo = $userCod";

$sql_query = $mysqli->query($query) or die("Falha na execução do código SQL: " . $mysqli->error);
if ($sql_query->num_rows > 0) {
    // Recupera os dados do usuário
    $row = $sql_query->fetch_assoc();
    $usernameMenu = $row['username'];
?>
    <div class="menu-area">
        
        <nav class="menu">
            <ul>
                <li><a href="home.php">inicio</a></li>
                <li class="dropdown">
                    <a href="#">Cadastros</a>
                    <ul class="submenu">
                    <li><a href="clienteListar.php">Clientes</a></li>
                        <li><a href="funcListar.php">Funcionário</a></li>
                        <li><a href="postoListar.php">Postos</a></li>
                        <li><a href="unidadeListar.php">Unidades</a></li>
                        <li><a href="cargoListar.php">Cargos</a></li>
                        <li><a href="setorListar.php">Setores</a></li>
                        <li><a href="cidadelistar.php">Cidades</a></li>
                        <li><a href="estadoListar.php">Estados</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="#">Escala De Serviço</a>
                    <ul class="submenu">
                    <li><a href="escalaMontar.php">Montar Escala</a></li>
                        <li><a href="">Consultar Escala</a></li>
                        <li><a href="">Listagem</a></li>
   
                    </ul>
                </li>

            </ul>
            <ul>
                <li class="dropdown">
                    <a><?php echo $usernameMenu ?></a>
                    <ul class="submenu  user">
                        <li><a href="meuPerfil.php">Meus Dados</a></li>
                        <li><a href="">Minha Escala</a></li>
                        <li><a style="color:brown;" href="logout.php">Sair</a></li>

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
<?php
} else {
    echo "falha ao recuperar dados de usuário<br>";
}
?>