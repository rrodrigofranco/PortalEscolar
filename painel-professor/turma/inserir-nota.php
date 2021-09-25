<?php 
require_once("../../conexao.php"); 

$nota = $_POST['nota'];
$atividade = $_POST['atividade'];
$turma = $_POST['turma'];
$periodo = $_POST['periodo'];
$aluno = $_POST['aluno'];

$query4 = $pdo->query("SELECT * FROM notas where turma = $turma and periodo = $periodo and aluno = $aluno and id_atv = $atividade");
$res4 = $query4->fetchAll(PDO::FETCH_ASSOC);



if(@count($res4) > 0){
	$pdo->query("UPDATE notas SET nota = '$nota' where aluno = '$aluno' and id_atv = '$atividade'");
}else{
	$pdo->query("INSERT INTO notas SET nota = '$nota' where aluno = '$aluno' and id_atv = '$atividade'");
	
}


echo 'Salvo com Sucesso!';

?>