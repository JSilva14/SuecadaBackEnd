<?php

if($_SERVER['REQUEST_METHOD']=='POST'){

//Receber valores da ap via POST
 $id_grupo = $_POST['id_grupo'];
 $criador = $_POST['criador'];
 $jogador1 = $_POST['jogador1'];
 $jogador2 = $_POST['jogador2'];
 $jogador3 = $_POST['jogador3'];
 $jogador4 = $_POST['jogador4'];
 $jogador5 = $_POST['jogador5'];
 $UUID = $_POST['UUID'];
 
 //Queries para verificar se jogador ja existe
$sqlCheckDisponibilidadeJogadores = 
"SELECT * FROM sessao WHERE (jogador1 in ($jogador1, $jogador2, $jogador3, $jogador4, $jogador5)
or jogador2 in ($jogador1, $jogador2, $jogador3, $jogador4, $jogador5)
or jogador3 in ($jogador1, $jogador2, $jogador3, $jogador4, $jogador5)
or jogador4 in ($jogador1, $jogador2, $jogador3, $jogador4, $jogador5)
or jogador5 in ($jogador1, $jogador2, $jogador3, $jogador4, $jogador5)) and flg_ativa=1";
  
 //importar script de conexão
 require_once('dbConnect.php');
 
 $r=mysqli_query($con,$sqlCheckDisponibilidadeJogadores);
 if($r){
	$result["sucesso"]="-1";
	$result["mensagem"]="Um ou mais jogadores já estão numa sessao";
	echo json_encode($result);
 }
 else{

$Create_Session = "INSERT INTO sessao (id_grupo, UUID, criador, jogador1, jogador2,
jogador3, jogador4, jogador5) 
VALUES($id_grupo, '".$UUID."', '".$criador."',
'".$jogador1."', '".$jogador2."', '".$jogador3."', 
'".$jogador4."', '".$jogador5."')";

$Create_Timeout_Event= "CREATE EVENT `".$UUID."`
ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 10 SECOND
DO
UPDATE sessao, jogador 
SET sessao.flg_ativa = 0, jogador.flg_ingame=0 
WHERE sessao.UUID = '".$UUID."' 
AND (jogador.username='".$jogador1."' 
	OR jogador.username='".$jogador2."'
	OR jogador.username='".$jogador3."'
	OR jogador.username='".$jogador4."'
	OR jogador.username='".$jogador5."') ";

$Update_Player_Status = "UPDATE jogador SET flg_ingame=1 
WHERE username IN 
('".$jogador1."', '".$jogador2."', '".$jogador3."', '".$jogador4."', '".$jogador5."') ";

$r2 = mysqli_query($con,$Create_Session); 

mysqli_query($con,$Create_Timeout_Event);

//Handler para sucesso
 if($r2)
{
	$result["sucesso"]="1";
	$result["mensagem"]="Sessão iniciada!";

	mysqli_query($con,$Update_Player_Status);
	
	echo json_encode($result);
}
//Handler para falhas
else
{	
	$result["sucesso"]="0";
	$result["mensagem"]="Ocorreu um erro!";

	echo json_encode($result);
	
 }
 }
}
 
 /*$resDisponibilidadeJogadores = mysqli_fetch_array($r);
 
 //caso username exista
 if(isset($checkDisponibilidadeJogadores)){

	$result["sucesso"]="-1";
	$result["mensagem"]="Um ou mais jogadores já estão numa sessao";
	echo json_encode($result);
 }
 //registar novo jogador
else{ 
$Create_Session = "INSERT INTO sessao (id_grupo, UUID, criador, jogador1, jogador2,
jogador3, jogador4, jogador5) 
VALUES('$id_grupo', '$UUID', '$criador','$jogador1','jogador2','$jogador3','$jogador4','$jogador5')";

//Handler para sucesso
 if(mysqli_query($con,$Create_Session))
{
	$result["sucesso"]="1";
	$result["mensagem"]="Sessão iniciada!";
	
	echo json_encode($result);
}
//Handler para falhas
else
{
	$result["sucesso"]="0";
	$result["mensagem"]="Ocorreu um erro!";
	
	echo json_encode($result);
 }
 }
}*/
 
?>