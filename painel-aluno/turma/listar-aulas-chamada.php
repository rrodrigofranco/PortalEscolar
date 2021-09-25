<?php 
require_once("../../conexao.php"); 
$idmat = @$_POST['id'];
$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];

$query = $pdo->query("SELECT * FROM matriculas where id = '$idmat' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$aluno = $res[0]['aluno']; 


$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' order by data asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_faltas = 0;
$total_aulas = count($res);
for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$nome = $res[$i]['nome'];
	$descricao = $res[$i]['descricao'];
	$arquivo = $res[$i]['arquivo'];
	$link = $res[$i]['link'];
	$id_aula = $res[$i]['id'];
	$data_aula = $res[$i]['data'];
	
	$data_aula = implode("/",array_reverse(explode("-",$data_aula)));
    $query2 = $pdo->query("SELECT * FROM chamadas where aula = '$id_aula' and aluno = '$aluno'");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
    
	if(!empty($res2[0]['presenca'])){
		$presenca = $res2[0]['presenca'];
	}
    
	echo 'Aula '. ($i+1) . ' - '.$nome.' - ';
    
    echo '  <b>'.$data_aula. '</b> ';

	
	if(@count($res2) > 0){
        if($presenca == 'P'){
            echo '-<i class="far fa-check-square ml-2 text-success"></i>';
        }else if($presenca == 'F'){
            $total_faltas = $total_faltas + 1;
            echo '- <span class="text-danger">'.$presenca.'</span>';
        }else if($presenca == 'J'){
            echo '- <span class="text-success">'.$presenca.'</span>';
        }
		
	}

	if($arquivo != ""){
		echo '<span class="ml-1" ><a href="../img/arquivos-aula/'.$arquivo.'" target="_blank" class="text-primary"> Ver Arquivo </a> </span>';
	}

	if($link != ""){
		echo '<span class="ml-1" ><a href="'.$link.'" target="_blank" class="text-primary"> Link </a> </span>';
	}
   
    echo '<br>';

}
	?>

<script type="text/javascript">
	 var total_aulas = "<?=$total_aulas?>";
	 var total_faltas = "<?=$total_faltas?>";
     
     $("#total_aulas").text(total_aulas);
	 $("#total_faltas").text(total_faltas);
	 
</script>