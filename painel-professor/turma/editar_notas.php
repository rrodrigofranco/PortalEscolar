<?php
require_once("../../conexao.php");

  $turma = $_POST['turma'];
  $periodo = $_POST['periodo'];
  $atividade = $_POST['atividade'];
  
  $query = $pdo->query("SELECT * FROM matriculas where turma = '$turma' order by id asc ");
  $res = $query->fetchAll(PDO::FETCH_ASSOC);
  
  for ($i=0; $i < count($res); $i++) { 
    
    $aluno = $res[$i]['aluno'];
    $query4 = $pdo->query("SELECT * FROM notas where turma = '$turma' and periodo = '$periodo' and aluno = '$aluno' and id_atv = '$atividade'");
    $res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
    $nota = $_POST["nota-$aluno"];
    $nota_max = $res4[0]['nota_max'];
    $id_atv = $res4[0]['id_atv'];
    if($nota != "" && $nota <= $nota_max){
      if(@count($res4) > 0){
        $pdo->query("UPDATE notas SET nota = '$nota' where aluno = '$aluno' and id_atv = '$atividade'");
      }else{
        $pdo->query("INSERT INTO notas SET nota = '$nota' where aluno = '$aluno' and id_atv = '$atividade'");
      }
    }
  }
    
     echo "Salvo com Sucesso!";
  ?>