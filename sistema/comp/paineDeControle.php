<div class="painel-controle">
    <!-- Itens do Painel de Controle -->
    <div class="area-logo-panel">
        <center><br><img style="width: 100px; height: 100px;" src="../images/logo.png" alt=""></center>
    </div>
    <ul>
        <li><i class="fa-solid fa-calendar-days"></i>&nbsp;<a href="minhaEscala.php"> Minha Escala</a></li>
        <li><i class="fa-solid fa-file-invoice"></i>&nbsp;<a href=""> Folha de Pagamento</a></li>
        <li><i class="fa-solid fa-user"></i>&nbsp;<a href="meuPerfil.php"> Dados de Cadastro</a></li>
    </ul>
    <ul style="bottom: 0px;">
        <li><i class="fa-solid fa-house"></i>&nbsp;<a href="home.php"> Home</a></li>
        <?php 
    if ($_SESSION['admin'] >= 1){
        
      ?>
      <li><i class="fa-solid fa-screwdriver-wrench"></i>&nbsp;<a href="adminPage.php"> Gerenciar <a style="color: green;">(admin)</a></a></li>
      <?php }?>
        <li><i style="color:brown;" class="fa-solid fa-right-from-bracket">&nbsp;</i><a href="logout.php" style="color: brown;"> Sair</a></li>
    </ul>




</div>

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
}
?>