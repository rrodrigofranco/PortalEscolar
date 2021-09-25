<?php
@session_start();
$cpf_aluno = @$_SESSION['cpf_usuario'];
if(@$_SESSION['nivel_usuario'] == null || @$_SESSION['nivel_usuario'] != 'aluno'){
	echo "<script language='javascript'> window.location='../index.php' </script>";
}

require_once("../conexao.php"); 


//totais dos cards
$hoje = date('Y-m-d');
$mes_atual = Date('m');
$ano_atual = Date('Y');
$dataInicioMes = $ano_atual."-".$mes_atual."-01";

$query = $pdo->query("SELECT * FROM alunos where cpf = '$cpf_aluno' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_aluno = $res[0]['id'];

$query = $pdo->query("SELECT * FROM matriculas where aluno = '$id_aluno' order by id desc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);

$totalCursos = @count($res);
$discConcluidas = 0;
$discAndamento = 0;
$presenca = 0;
$total_presenca = 0;

for($i = 0; $i < $totalCursos; $i++){
	$turma = $res[$i]['turma'];
	$query2 = $pdo->query("SELECT * FROM turmas where id = '$turma' and data_final < curDate()");
	$res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
	$discConcluidas = $discConcluidas + @count($res2);

	$query_presenca = $pdo->query("SELECT * FROM chamadas where turma = '$turma' and aluno = '$id_aluno'");
	$res_presenca = $query_presenca->fetchAll(PDO::FETCH_ASSOC);                    
	$total_presenca = $total_presenca + @count($res_presenca);

	for($j=0; $j < @count($res_presenca); $j++){
	if($res_presenca[$j]['presenca'] == 'P' || $res_presenca[$j]['presenca'] == 'J'){
		$presenca = $presenca + 1;
	}
	}

	$query3 = $pdo->query("SELECT * FROM turmas where id = '$turma' and data_final >= curDate()");
	$res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
	$discAndamento = $discAndamento + @count($res3);
}

if ($presenca != 0){
		$presenca = round($presenca/$total_presenca * 100);
}


?>








<div class="row">
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1">Cursos Matriculados</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $totalCursos ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-info"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-success text-uppercase mb-1">Disciplinas Concluídas</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $discConcluidas ?> </div>
					</div>
					<div class="col-auto">
						<i class="fas fa-users fa-2x text-success"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-danger shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Disciplinas Pendentes</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $discAndamento ?> </div>
					</div>
					<div class="col-auto" align="center">
						<i class="fas fa-clipboard-list fa-2x text-danger"></i>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-secondary shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">% Frequência</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $presenca ?></div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-secondary"></i>
					</div>
				</div>
			</div>
		</div>
	</div>

</div>




<div class="row">

<?php 

$query = $pdo->query("SELECT * FROM matriculas where aluno = '$id_aluno' order by id desc ");
                    $res = $query->fetchAll(PDO::FETCH_ASSOC);
                   

                  for ($i=0; $i < count($res); $i++) { 
                  foreach ($res[$i] as $key => $value) {
                  }

                   $id_turma = $res[$i]['turma'];
                    $id_mat = $res[$i]['id'];


                    $query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
                    $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                    $disciplina = $res_2[0]['disciplina'];
                    $horario = $res_2[0]['horario'];
                    $dia = $res_2[0]['dia'];
                    $ano = $res_2[0]['ano'];
                  	$data_final = $res_2[0]['data_final'];

                  	$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

                    $query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
                    $res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);
                    
                    $nome_disc = $res_resp[0]['nome'];


                    if($data_final < date('Y-m-d')){
                    	$classe_card = 'text-success';
                    }else{
                    	$classe_card = 'text-danger';
                    }

 ?>	

<div class="col-xl-3 col-md-6 mb-4">
	<a class="text-dark" href="index.php?pag=turma&id=<?php echo $id_mat ?>" title="Informações da Turma">
			<div class="card <?php echo $classe_card ?> shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold  <?php echo $classe_card ?> text-uppercase"><?php echo $nome_disc ?></div>
							<div class="text-xs text-secondary"><?php echo $horario ?> <br> <?php echo $dia ?> </div>
						</div>
						<div class="col-auto" align="center">
							<i class="far fa-calendar-alt fa-2x  <?php echo $classe_card ?>"></i><br>
							<span class="text-xs"><?php echo $data_finalF ?></span>
						</div>
					</div>
				</div>
			</div>
		</a>
		</div>



<?php } ?>

</div>