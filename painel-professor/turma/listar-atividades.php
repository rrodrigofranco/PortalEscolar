<?php 
require_once("../../conexao.php"); 

$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];

$query = $pdo->query("SELECT * FROM atividades where turma = '$turma' and periodo = '$periodo' order by data asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_notas_atividades = 0;
for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}
	$descricao = $res[$i]['descricao'];
	$id_atividade = $res[$i]['id'];
	$nota_max = $res[$i]['nota_max'];
	$total_notas_atividades = $total_notas_atividades  + $nota_max;
    $data_aula = $res[$i]['data'];

	$data_aula = implode("/",array_reverse(explode("-",$data_aula)));

	echo $descricao . ' - '.$nota_max. ' Pontos - <b>'.$data_aula.'</b>  <a href="index.php?pag=turma&funcao=lancarnotasatv&id='. $turma .'&id_periodo='.$periodo .'&id_atividade='. $id_atividade .'&editar=0" title="Lançar Notas "><i class="fas fa-sticky-note fa-1x"></i></a><a onclick="deletarAtividade('.$id_atividade.')" href="#" title="Deletar Atividade"><i class="far fa-trash-alt ml-2 text-danger"></i></a><br>';
}
?>

<script type="text/javascript">
	 
	 var total_notas_atividades = "<?=$total_notas_atividades?>";

	 $("#total_notas_atividades").text(total_notas_atividades);
	 
</script>

