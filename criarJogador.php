<?php
if($_SERVER['REQUEST_METHOD']=='POST'){

 
 $nome = $_POST['nome'];
 $id_grupo = $_POST['id_grupo'];
 $pontos_italiana = $_POST['pontos_italiana'];
 

 $CheckSQL = "SELECT * FROM jogador WHERE nome='$nome'";
 require_once('dbConnect.php');
 
 $check = mysqli_fetch_array(mysqli_query($con,$CheckSQL));
 
 if(isset($check)){

	$result["sucesso"]="-1";
	$result["mensagem"]="O jogador $jogador ja existe";
	echo json_encode($result);

 }
else{ 
$Sql_Query = "INSERT INTO jogador (nome) VALUES('$nome');
INSERT INTO jogador_grupo (id_grupo, id_jogador, pontos_italiana) VALUES ($id_grupo, 
	(select id from jogador where nome = '$nome'), $pontos_italiana"; 


 if(mysqli_query($con,$Sql_Query))
{
	$result["sucesso"]="1";
	$result["mensagem"]="Jogador Registado com sucesso!";
	
	echo json_encode($result);
}
else
{
	$result["sucesso"]="0";
	$result["mensagem"]="Ocorreu um erro!";
	
	echo json_encode($result);
 }
 }
}
 
?>