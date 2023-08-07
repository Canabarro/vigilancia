<?php
$host = 'localhost';
$db = 'sistemavig';
$user = 'root';
$pass = '1234';
$mysqli = new mysqli($host, $user, $pass, $db);
if ($mysqli->connect_errno) {
    die("falha na conexao");
}
function formatar_data($data)
{
    return implode('/', array_reverse(explode('-', $data)));
}
function formatar_telefone($telefone)
{
    $ddd = substr($telefone, 0, 2);
    $parte1 = substr($telefone, 2, 5);
    $parte2 = substr($telefone, 7);
    return "($ddd) $parte1-$parte2";
}

date_default_timezone_set('America/Sao_Paulo');