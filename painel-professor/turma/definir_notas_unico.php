<?php
    require_once("../../conexao.php"); 
    $turma = $_POST['turma'];
    $periodo = $_POST['periodo'];
    $atividade = $_POST['atividade'];
    $nota = $_POST['nota'];
    $aluno = $_POST['aluno'];
   
    $query4 = $pdo->query("SELECT * FROM notas where turma = $turma and periodo = $periodo and aluno = $aluno and id_atv = $atividade");
    $res4 = $query4->fetchAll(PDO::FETCH_ASSOC);
    
    if(@count($res4) > 0){
      $pdo->query("UPDATE notas SET nota = '$nota' where aluno = '$aluno' and id_atv = '$atividade'");
    }else{
      $pdo->query("INSERT INTO notas SET nota = '$nota' where aluno = '$aluno' and id_atv = '$atividade'");
        
    }

    echo "Salvo com Sucesso!";
  ?>