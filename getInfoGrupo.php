<?php 
 
 
 //script para receber id do grupo que o jogador se encontra a visualizar atualmente
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $nome  = $_POST['nome'];
 
 require_once('dbConnect.php');
 
 $sql = "SELECT id, codigo_acesso FROM grupo WHERE nome='".$nome."'";
 
 $r = mysqli_query($con,$sql);
 
 $res = mysqli_fetch_array($r);
 
  if(isset($res)){
	  
 $result = array();
 
 $resultGrupoInfo = array('sucesso' => 1,
		'mensagem' => "sucesso",
		'id' => $res["id"],
		'codigo_acesso' => $res["codigo_acesso"]);
		
echo json_encode($resultGrupoInfo, JSON_FORCE_OBJECT);
  }
  else{
	  
	  $result=array(
			'sucesso'=>0,
			'mensagem'=>"Erro ao obter informações do grupo!");

			echo json_encode($resultGrupoInfo, JSON_FORCE_OBJECT);
			
  }
 
 mysqli_close($con);
 
 }