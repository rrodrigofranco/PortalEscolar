<?php 
require_once("../../conexao.php"); 
$idmat = @$_POST['id'];
$turma = @$_POST['turma'];
$periodo = @$_POST['periodo'];

$query = $pdo->query("SELECT * FROM matriculas where id = '$idmat' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$aluno = $res[0]['aluno']; 

$query = $pdo->query("SELECT * FROM notas where turma = '$turma' and periodo = '$periodo' and aluno = '$aluno' order by data asc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$total_notas = 0;
$total_atividades = count($res);
for ($i=0; $i < count($res); $i++) { 
	foreach ($res[$i] as $key => $value) {
	}

	$nota = $res[$i]['nota'];
	$descricao = $res[$i]['descricao'];
	$nota_max = $res[$i]['nota_max'];
	
	$id_nota = $res[$i]['id'];
	$data_aula = $res[$i]['data'];

	$data_aula = implode("/",array_reverse(explode("-",$data_aula)));

	$total_notas = $total_notas + $nota;
    if($nota < $nota_max * 0.6){
        echo $descricao . ' - Nota: <b><span class="text-danger">' .$nota. ' </span>/ ' .$nota_max.'</b> - <b>'.$data_aula.'</b><br>';
    }else{
        echo $descricao . ' - Nota: <b><span class="text-success">' .$nota. ' </span>/ ' .$nota_max.'</b> - <b>'.$data_aula.'</b><br>';
    }

}
?>


<script type="text/javascript">
	 
	 var total_notas = "<?=$total_notas?>";
     var total_atividades = "<?=$total_atividades?>";

	 $("#total_notas").text(total_notas);
     $("#total_atividades").text(total_atividades);
	 
</script>

