<?php 
 
 
 //script para receber id do grupo que o jogador se encontra a visualizar atualmente
 if($_SERVER['REQUEST_METHOD']=='GET'){
 
 $username  = $POST['username'];
 
 require_once('dbConnect.php');
 
 //query para retornar info sobre o jogador logado
 $sql = "SELECT id FROM jogador WHERE LOWER(username)=LOWER('$username')";
  
 //executar query de info utilizando conexao importada
 $r = mysqli_query($con,$sql);
 
 $res = mysqli_fetch_array($r);
 
 //Array para guardar id do jogador
 $result = array();
 
 array_push($result,array("id"=>$res['id']));
 
 echo json_encode(array("result"=>$result));
 
 mysqli_close($con);
 
 }