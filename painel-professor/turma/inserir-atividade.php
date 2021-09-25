<?php 
require_once("../../conexao.php"); 
$nota = 0;
$descricao = $_POST['descricao'];
$nota_max = $_POST['nota-max'];
$turma = $_POST['turma'];
$periodo = $_POST['periodo'];
$data = $_POST['data_aula'];

if($descricao == ""){
	echo 'O descrição é Obrigatória!';
	exit();
}

if($nota == ""){
	$nota = 0;
}

if($nota_max == ""){
	echo 'A nota máxima é Obrigatória!';
	exit();
}

$query0 = $pdo->query("SELECT * FROM periodos where id = '$periodo'");
$res0 = $query0->fetchAll(PDO::FETCH_ASSOC);

$total_pontos = $res0[0]['total_pontos'];

$query1 = $pdo->query("SELECT * FROM atividades where turma = '$turma' and periodo = '$periodo'");
$res1 = $query1->fetchAll(PDO::FETCH_ASSOC);
$nota = 0;

for ($i = 0; $i < count($res1); $i++) { 
    $nota = $nota + $res1[$i]['nota_max'];
}
$nota = $nota + $nota_max;

if($nota > $total_pontos){
	echo 'A nota da atividade não pode ser maior que a nota total do período!';
	exit();
}

$res2 = $pdo->prepare("INSERT INTO atividades SET turma = :turma, periodo = :periodo, descricao = :descricao, nota_max = :nota_max, data = :data");	

$res2->bindValue(":descricao", $descricao);
$res2->bindValue(":nota_max", $nota_max);
$res2->bindValue(":turma", $turma);
$res2->bindValue(":periodo", $periodo);
$res2->bindValue(":data", $data);

$res2->execute();

$query_aux = $pdo->query("SELECT * FROM atividades where turma = '$turma' and periodo = '$periodo' and  descricao = '$descricao'");
$res_aux = $query_aux->fetchAll(PDO::FETCH_ASSOC);
$id_atv = $res_aux[0]['id'];

$query = $pdo->query("SELECT * FROM matriculas where turma = '$turma' order by id asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
    $aluno = $res[$i]['aluno'];

    $query_r = $pdo->query("SELECT * FROM alunos where id = '$aluno' order by nome asc");
    $res_r = $query_r->fetchAll(PDO::FETCH_ASSOC);

    $id_aluno_chamada = $res_r[0]['id'];

    $res2 = $pdo->prepare("INSERT INTO notas SET turma = :turma, periodo = :periodo, aluno = :aluno, id_atv = :id_atv, descricao = :descricao, nota_max = :nota_max, data = :data");	
	
    //$res2->bindValue(":nota", $nota);
    $res2->bindValue(":id_atv", $id_atv);
    $res2->bindValue(":descricao", $descricao);
    $res2->bindValue(":nota_max", $nota_max);
    $res2->bindValue(":turma", $turma);
    $res2->bindValue(":periodo", $periodo);
    $res2->bindValue(":aluno", $aluno);
    $res2->bindValue(":data", $data);

    $res2->execute();
}

echo 'Salvo com Sucesso!';

?>