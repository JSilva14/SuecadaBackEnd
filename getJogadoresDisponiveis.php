<?php 
  
//Script para receber informação dos jogadores de um determinado grupo (grupo atual)
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 //Receber jogadores via POST utilizando nome do grupo atual
 $nome  = $_POST['nome'];
 
 //importar conexão
 require_once('dbConnect.php');
 
 $sql = "SELECT * FROM jogador j INNER JOIN jogador_grupo x ON j.id = x.id_jogador where id_grupo=
 (SELECT id from grupo where nome='".$nome."') and flg_ingame=0";
	
 $result=mysqli_query($con,$sql);

 $count=mysqli_num_rows($result);

 $jogadores = array();
if (!mysqli_query($con,$sql))
{ 
    die('Erro: ' . mysql_error());
}
else
{
    while($row=mysqli_fetch_array($result))
    {
	  array_push($jogadores,array("username"=>$row['username']));	
    }
}
 mysqli_close($con); 
 echo json_encode(array("resultjogadores"=>$jogadores));
}