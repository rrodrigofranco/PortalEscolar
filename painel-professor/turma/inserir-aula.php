<?php 
require_once("../../conexao.php"); 

$nome = $_POST['nome'];
$descricao = $_POST['descricao'];
$data_aula = $_POST['data_aula'];
$turma = $_POST['turma'];
$periodo = $_POST['periodo'];
$link = $_POST['link'];

if($nome == ""){
	echo 'O nome é Obrigatório!';
	exit();
}

if($data_aula == ""){
	echo 'A data é Obrigatório!';
	exit();
}

$res = $pdo->prepare("INSERT INTO aulas SET turma = :turma, nome = :nome, descricao = :descricao, periodo = :periodo, data = :data_aula, link = :link");	

$res->bindValue(":nome", $nome);
$res->bindValue(":descricao", $descricao);
$res->bindValue(":turma", $turma);
$res->bindValue(":periodo", $periodo);
$res->bindValue(":data_aula", $data_aula);
$res->bindValue(":link", $link);
$res->execute();


echo 'Salvo com Sucesso!';

?>