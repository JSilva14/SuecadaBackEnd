<?php 
 
 //script para receber id do grupo que o jogador se encontra a visualizar atualmente
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $uuid  = $_POST['uuid'];
 
 require_once('dbConnect.php');
 
 //query para retornar info sobre o jogador logado
 $sql = "UPDATE sessao 
        SET data_update=CURRENT_TIMESTAMP 
        WHERE UUID='".$uuid."'";
  
 //executar query de info utilizando conexao importada
 $r = mysqli_query($con,$sql);
 
 if($r){
	$result["sucesso"]="1";
	$result["mensagem"]="Atualizado!";

      echo json_encode($result);
}
else{
      $result["sucesso"]="0";
	$result["mensagem"]="Ocorreu um erro!";

      echo json_encode($result);
    }

 }

 mysqli_close($con);