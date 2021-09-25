<?php 
require_once("../../conexao.php"); 

$id_atv = $_POST['idatividade'];

$pdo->query("DELETE FROM atividades WHERE id = '$id_atv'");
$pdo->query("DELETE FROM notas WHERE id_atv = '$id_atv'");

echo 'Excluído com Sucesso!';

?>