<?php 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 //Receber valores via POST
 $username = $_POST['username'];
 $password = $_POST['password'];
 
 //Criar query para encontrar jogador com username especificado no login
 $sql = "SELECT username, password FROM jogador WHERE LOWER(username)='$username'";
 
 //importar script de conexão
 require_once('dbConnect.php');
 
 //executar query
 $r = mysqli_query($con,$sql);
 
 //receber resultado
 $res = mysqli_fetch_array($r);
 
 //verificar password inserida contra a hash na BD
 if(isset($res)){
	 //dehash da password
	 $hashedPasswprdCheck = password_verify($password, $res['password']);
	
	//Handler para pass nao coincidente com hash
	if($hashedPasswprdCheck == false){
		//$result["sucesso"]=0;
		//$result["mensagem"]="Username ou Password Inválidos";
		$result=array(
			'sucesso'=>0,
			'mensagem'=>"Password Inválida");

			echo json_encode($result, JSON_FORCE_OBJECT);
	}
	//Caso de sucesso
	else if($hashedPasswprdCheck == true){
		//devolver mensagem de sucesso e info do jogador que está a efetuar login
		
		
		$sqlJogadorInfo="SELECT id, username, nome, apelido, email FROM jogador WHERE LOWER(username)='$username'";
		
		//executar query
		$rJogadorInfo = mysqli_query($con,$sqlJogadorInfo);
 
		//receber resultado num array
		$resJogadorInfo = mysqli_fetch_array($rJogadorInfo);
				
		
		//Array para guardar info do jogador
		$resultJogadorInfo = array('sucesso' => 1,
		'mensagem' => "sucesso",
		'id' => $resJogadorInfo["id"],
		'username' => $resJogadorInfo["username"],
		'nome' => $resJogadorInfo["nome"],
		'apelido' => $resJogadorInfo["apelido"],
		'email' => $resJogadorInfo["email"]);
 
		/*echo $resultJogadorInfo["sucesso"];
		echo $resultJogadorInfo["id"];
		echo $resultJogadorInfo["username"];
		echo $resultJogadorInfo["nome"];
		echo $resultJogadorInfo["apelido"];
		echo $resultJogadorInfo["email"];*/
				
		/*array_push($resultJogadorInfo,array("sucesso"=>1, "mensagem"=>"sucesso","id"=>$resJogadorInfo['id'], 
		"username"=>$resJogadorInfo['username'], "nome"=>$resJogadorInfo['nome'],"apelido"=>$resJogadorInfo['apelido'], 
		"email"=>$resJogadorInfo['email']));*/
 
		echo json_encode($resultJogadorInfo, JSON_FORCE_OBJECT);
				
	}
 }else{
 //Caso de falhas

//$result["sucesso"]=2;
//$result["mensagem"]="Jogador não registado";
$result=array(
 'sucesso'=>2,
 'mensagem'=>"Jogador não registado");

echo json_encode($result, JSON_FORCE_OBJECT);
 }
 mysqli_close($con);
 }