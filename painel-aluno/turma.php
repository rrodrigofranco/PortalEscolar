<?php 

@session_start();
require_once("../conexao.php"); 

$id_mat = $_GET['id'];

$query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
$res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
$disciplina = $res_2[0]['disciplina'];
$horario = $res_2[0]['horario'];
$dia = $res_2[0]['dia'];
$ano = $res_2[0]['ano'];
$data_final = $res_2[0]['data_final'];
$data_inicio = $res_2[0]['data_inicio'];
$professor = $res_2[0]['professor'];

$query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
$nome_disc = $res_resp[0]['nome'];

$query = $pdo->query("SELECT * FROM matriculas where id = '$id_mat' order by id desc ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$id_turma = $res[0]['turma'];
$id_aluno = $res[0]['aluno'];

$id_get_periodo = @$_GET['id_periodo'];

$query_resp = $pdo->query("SELECT * FROM periodos where id = '$id_get_periodo' ");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                 
$nome_periodo = $res_resp[0]['nome'];
$maximo_nota = $res_resp[0]['total_pontos'];


$query_aulas = $pdo->query("SELECT * FROM aulas where turma = '$id_turma'");
$res_aulas = $query_aulas->fetchAll(PDO::FETCH_ASSOC);                    
$aulas_total = @count($res_aulas);


$query_presenca = $pdo->query("SELECT * FROM chamadas where turma = '$id_turma' and aluno = '$id_aluno'");
$res_presenca = $query_presenca->fetchAll(PDO::FETCH_ASSOC);                    
$total_presenca = @count($res_presenca);

$presenca = 0;
for($i=0; $i <$total_presenca; $i++){
  if($res_presenca[$i]['presenca'] == 'P' || $res_presenca[$i]['presenca'] == 'J'){
    $presenca = $presenca + 1;
  }
}
if ($presenca != 0){
  $presenca = $presenca/$total_presenca * 100;
}

$query_resp = $pdo->query("SELECT * FROM aulas where turma = '$id_turma' and periodo = '$id_get_periodo'");
$res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                 
$total_aulas = @count($res_resp);

$query_2 = $pdo->query("SELECT * FROM turmas where id = '$id_turma' ");
                    $res_2 = $query_2->fetchAll(PDO::FETCH_ASSOC);
                    $disciplina = $res_2[0]['disciplina'];
                    $horario = $res_2[0]['horario'];
                    $dia = $res_2[0]['dia'];
                    $ano = $res_2[0]['ano'];
                  	$data_final = $res_2[0]['data_final'];
                  	$data_inicio = $res_2[0]['data_inicio'];
                  	$professor = $res_2[0]['professor'];


                  	//RECUPERAR O TOTAL DE MESES ENTRE DATAS
$d1 = new DateTime($data_inicio);
$d2 = new DateTime($data_final);
$intervalo = $d1->diff( $d2 );
$anos = $intervalo->y;
$meses = $intervalo->m + ($anos * 12);

                  	$data_finalF = implode('/', array_reverse(explode('-', $data_final)));

                    $query_resp = $pdo->query("SELECT * FROM disciplinas where id = '$disciplina' ");
                    $res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
                    $nome_disc = $res_resp[0]['nome'];


                     $query_resp = $pdo->query("SELECT * FROM professores where id = '$professor' ");
                    $res_resp = $query_resp->fetchAll(PDO::FETCH_ASSOC);                    
                    $nome_prof = $res_resp[0]['nome'];
                    $email_prof = $res_resp[0]['email'];
                    $imagem_prof = $res_resp[0]['foto'];


                    if($data_final < date('Y-m-d')){
                    	$concluido = 'Sim';
                    }else{
                    	$concluido = 'Não';
                    }

  $query3 = $pdo->query("SELECT * FROM alunos where id = '$id_aluno' order by id desc ");
  $res3 = $query3->fetchAll(PDO::FETCH_ASSOC);
  $nome_aluno = $res3[0]['nome'];
 ?>

 <h6><?php echo strtoupper($nome_disc) ?></h6>
 <hr>

<small>
<div class="mb-3">
 <span class="mr-3"><i><b>Aulas Concluídas:</b> <?php echo $aulas_total ?> Aulas</i></span>
 <span class="mr-3"><i><b>Disciplina Concluída </b> <?php echo $concluido ?></i></span>
 <span class="mr-3"><i><b>Dias de Aula </b> <?php echo $dia ?></i></span>
 <span class="mr-3"><i><b>Horário Aula </b> <?php echo $horario ?></i></span>
 <span class="mr-3"><i><b>Ano Início </b> <?php echo $ano ?></i></span>
 <span class="mr-3"><i><b>Data da Conclusão </b> <?php echo $data_finalF ?></i></span>
</div>
</small>

<hr>

<small>
<div class="mb-3">
 <span class="mr-3"><img src="../img/professores/<?php echo $imagem_prof ?>" width="40px"></i></span>
 <span class="mr-3"><i><b>Professor:</b> <?php echo $nome_prof ?></i></span>
 <span class="mr-3"><i><b>Email Professor </b> <?php echo $email_prof ?></i></span>


</div>
</small>
<hr>


<div class="row">

<div class="col-xl-3 col-md-6 mb-4">
	<a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_mat ?>&id_turma=<?php echo $id_turma ?>&chamada=sim" title="Informações da Turma">
			<div class="card text-dark shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold  text-dark text-uppercase">FREQUÊNCIA</div>
							<div class="text-xs text-secondary"> <?php echo round($presenca) ?>% DE FREQUÊNCIA</div>
						</div>
						<div class="col-auto" align="center">
							<i class="fas fa-calendar-day fa-2x  text-dark"></i><br>
							<span class="text-xs"></span>
						</div>
					</div>
				</div>
			</div>
		</a>
</div>




<div class="col-xl-3 col-md-6 mb-4">
	<a class="text-dark" href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_mat ?>&notas=sim"  title="Informações da Turma">
			<div class="card text-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold  text-primary text-uppercase">BOLETIM</div>
							<div class="text-xs text-secondary"> CONSULTAR NOTAS</div>
						</div>
						<div class="col-auto" align="center">
							<i class="fas fa-file-invoice fa-2x  text-primary"></i><br>
							<span class="text-xs"></span>
						</div>
					</div>
				</div>
			</div>
		</a>
</div>

</div>



<div class="modal" id="modal-periodos" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <?php 
        $query = $pdo->query("SELECT * FROM periodos where turma = '$id_turma' order by id asc ");
        $res = $query->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($res); $i++) { 
          foreach ($res[$i] as $key => $value) {
          }

          $nome = $res[$i]['nome'];
          $id_periodo = $res[$i]['id'];
          ?>

         <?php if(@$_GET['aulas'] != ""){ ?>
          <a href="index.php?pag=turma&funcao=aulas&id=<?php echo $id_mat ?>&id_turma=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>" name="btn-salvar-aula" class="btn btn-secondary text-light"><?php echo $nome ?></a>
        <?php } ?>

         <?php if(@$_GET['notas'] != ""){ ?>
          <a href="index.php?pag=turma&funcao=notas&id=<?php echo $id_mat ?>&id_turma=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>" name="btn-salvar-aula" class="btn btn-secondary text-light"><?php echo $nome ?></a>
        <?php } ?>

        <?php if(@$_GET['atividades'] != ""){ ?>
          <a href="index.php?pag=turma&funcao=atividades&id=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>" name="btn-salvar-aula" class="btn btn-secondary text-light"><?php echo $nome ?></a>
        <?php } ?>


          <?php if(@$_GET['chamada'] != ""){ ?>
            <a href="index.php?pag=turma&funcao=chamada&id=<?php echo $id_mat ?>&id_turma=<?php echo $id_turma ?>&id_periodo=<?php echo $id_periodo ?>" name="btn-salvar-aula" class="btn btn-secondary text-light"><?php echo $nome ?></a>
        <?php } ?>


        <?php } ?>

      </div>

    </div>
  </div>
</div>


<div class="modal" id="modal-notas" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <h4>
        <a class='text-success mr-1' href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_mat ?>&notas=sim" title='Voltar'><i type="button" class="fas fa-arrow-alt-circle-left"></i></a>
       </h4>
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_periodo ?> - <span id="total_atividades">  </span> Atividades</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            
      <span class=""><b>Notas do Aluno </b></span>
            - <span id="total_notas">  </span> de <span id="maximonota"> <?php echo $maximo_nota ?></span> Pontos
            <small><div id="listar-notas" class="mt-2">
            
            

            </div></small>
          </div>
          <div class="col-md-5">
          
          <?php $id_mat = @$_GET['id']; ?>
          <?php $id_per = @$_GET['id_periodo']; ?>


      <div align="center" id="mensagem_chamada" class="">

      </div>

    </div>

  </div>
</div>
</div>


<div class="modal" id="modal-chamada-aulas" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       <h4>
        <a class='text-success mr-1' href="index.php?pag=turma&funcao=periodos&id=<?php echo $id_mat ?>&chamada=sim" title='Voltar'><i type="button" class="fas fa-arrow-alt-circle-left"></i></a>
       </h4>
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_periodo ?> - <?php echo $total_aulas ?> Aulas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

            <span class=""><b>Aulas do Curso</b></span>
            - <span id="total_faltas"> </span> Faltas de <span id="total_aulas"> </span> Aulas
            <small><div id="listar-aulas-chamada" class="mt-2">
            

            </div></small>
          </div>
          <div class="col-md-5">
          
          <?php $id_mat = @$_GET['id']; ?>
          <?php $id_per = @$_GET['id_periodo']; ?>


      <div align="center" id="mensagem_chamada" class="">

      </div>

    </div>

  </div>
</div>
</div>

<div class="modal" id="modal-aulas" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><?php echo $nome_disc ?> - <?php echo $nome_periodo ?> - <?php echo $total_aulas ?> Aulas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-md-7">

            <span class=""><b>Aulas do Curso</b></span>
            <small><div id="listar-aulas" class="mt-2">

            </div></small>

          </div>
          <div class="col-md-5">
          <?php $id_turma = @$_GET['id_turma']; ?>
          <?php $id_per = @$_GET['id_periodo']; ?>
        </div>
      </div>

      <div align="center" id="mensagem_aulas" class="">

      </div>

    </div>

  </div>
</div>
</div>

<?php
  if (@$_GET["funcao"] != null && @$_GET["funcao"] == "periodos") {
    echo "<script>$('#modal-periodos').modal('show');</script>";
  }
  if (@$_GET["funcao"] != null && @$_GET["funcao"] == "aulas") {
    echo "<script>$('#modal-aulas').modal('show');</script>";
  }

  if (@$_GET["funcao"] != null && @$_GET["funcao"] == "notas") {
    echo "<script>$('#modal-notas').modal('show');</script>";
  }

  if (@$_GET["funcao"] != null && @$_GET["funcao"] == "chamada") {
    echo "<script>$('#modal-chamada-aulas').modal('show');</script>";
  }

?>

<!--AJAX PARA LISTAR OS DADOS -->
<script type="text/javascript">
  $(document).ready(function(){
  // listarDados();
   listarAulasChamada();
   listarNotas();
 //  listarAtividades();
   

 })
</script>


<script type="text/javascript">
  function aulasChamada(idturma, periodo, idaluno) {
    event.preventDefault();
    
    var pag = "<?=$pag?>";
       document.getElementById('txtidaluno').value = idaluno;
       
       $("#txtnomealuno").text(nomealuno);
       $("#maximonota").text(maximonota);

       listarAulasChamada(idaluno);

       $('#modal-lancar-notas').modal('show');
    }
  
</script>

<script type="text/javascript">
  function listarAulasChamada(){
    var pag     = "<?=$pag?>";
    var id      = "<?=$id_mat?>";
    var turma   = "<?=$id_turma?>";
    var periodo = "<?=$id_per?>";
    //alert(id);
    $.ajax({
     url: pag + "/listar-aulas-chamada.php",
     method: "post",
     data: {id, turma, periodo},
     dataType: "html",
     success: function(result){
      $('#listar-aulas-chamada').html(result)

    },


  })
  }
</script>

<script type="text/javascript">
  function listarNotas(){
    var pag     = "<?=$pag?>";
    var id      = "<?=$id_mat?>";
    var turma   = "<?=$id_turma?>";
    var periodo = "<?=$id_per?>";
    //alert(id);
    $.ajax({
     url: pag + "/listar-notas.php",
     method: "post",
     data: {id, turma, periodo},
     dataType: "html",
     success: function(result){
      $('#listar-notas').html(result)

    },


  })
  }
</script>

