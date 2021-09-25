<?php 
require_once("../../conexao.php"); 

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];

$query = $pdo->query("SELECT * FROM aulas where turma = '$turma' and periodo = '$periodo' order by data asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$nome 	   = $res[$i]['nome'];
	$descricao = $res[$i]['descricao'];
	$arquivo   = $res[$i]['arquivo'];
	$link      = $res[$i]['link'];
	$id_aula   = $res[$i]['id'];
	$data_aula = $res[$i]['data'];

	$data_aula = implode("/",array_reverse(explode("-",$data_aula)));

	echo 'Aula '. ($i+1) . ' - '. $nome .'<a href="index.php?pag=turma&funcao=fazerchamada&id='. $turma .'&id_periodo='.$periodo .'&id_aula='. $id_aula .'" title="Fazer Chamada - '.$data_aula.'"><i class="far fa-calendar ml-2 text-info"></i></a><a onclick="upload('.$id_aula.')" href="#" title="Carregar Arquivo"><i class="far fa-file ml-2 text-primary"></i></a><a onclick="deletarAula('.$id_aula.')" href="#" title="deletar aula"><i class="far fa-trash-alt ml-2 text-danger"></i></a>';

	if($arquivo != ""){
		echo '<span class="ml-1" ><a href="../img/arquivos-aula/'.$arquivo.'" target="_blank" class="text-primary"> Ver Arquivo </a> </span>';
	}

	if($link != ""){
		echo '<span class="ml-1" ><a href="'.$link.'" target="_blank" class="text-primary"> Link </a> </span>';
	}

	$query2 = $pdo->query("SELECT * FROM chamadas where aula = '$id_aula' ");
    $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
     

	if(@count($res2) > 0){
		echo '<i class="far fa-check-square ml-2 text-success"></i><br>';
	}else{
		echo '<br>';
	}

}
	?>

