<?php 
  
//Script para receber informação dos jogadores de um determinado grupo (grupo atual)
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 //Receber jogadores via GET utilizando nome do grupo atual
 $nome  = $_POST['nome'];
 
 //importar conexão
 require_once('dbConnect.php');
 
 $sql = "SELECT * FROM jogador j INNER JOIN jogador_grupo x ON j.id = x.id_jogador where id_grupo=
 (SELECT id from grupo where nome='".$nome."')";
	
 $result=mysqli_query($con,$sql);

 $jogadores = array();
if (!$result)
{ 
    $resultStatus = array('Status'=>array('sucesso' => 0,
		'mensagem' => "Erro de conexão!"));
    echo json_encode($resultStatus);
}
else
{
	$count=mysqli_num_rows($result);
	
	if($count>0)
	{
		$resultStatus = array('Status'=>array('sucesso' => 1,
		'mensagem' => utf8_encode("sucesso")));
		
		$tempArray=array();
		while($row=mysqli_fetch_array($result))
    {
	  array_push($tempArray,array("id"=>$row['id'],
								  "username"=>$row['username'],
								  "nome"=>$row['nome'],
								  "apelido"=>$row['apelido'],
								  "pontuacao"=>$row['pontuacao'],
								  "email"=>$row['email']));	
     }
	 $resultJogadores=array('Jogadores'=>$tempArray);
	 
	 echo json_encode(array_merge($resultStatus,$resultJogadores));	
	}
	else{
		$resultStatus = array('Status'=>array('sucesso' => 2,
		'mensagem' => "Sem Jogadores!"));
		echo json_encode($resultStatus);
	}
	  
}
 //echo json_encode(array("resultjogadores"=>$jogadores));
}
mysqli_close($con); 