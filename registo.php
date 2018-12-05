<?php

if($_SERVER['REQUEST_METHOD']=='POST'){

//Receber valores da ap via POST
 $nome = $_POST[('nome')];
 $apelido = $_POST[('apelido')];
 $username = $_POST[('username')];
 $email = $_POST[('email')];
 $password = $_POST[('password')];
 $hashed_password = password_hash($password, PASSWORD_BCRYPT);

 //Queries para verificar se jogador ja existe
 $CheckSqlUsername = "SELECT * FROM jogador WHERE LOWER(username)=LOWER('$username')";
 $CheckSqlEmail = "SELECT * FROM jogador WHERE LOWER(email)=LOWER('$email')";
 
 //importar script de conexão
 require_once('dbConnect.php');
 
 $checkUsername = mysqli_fetch_array(mysqli_query($con,$CheckSqlUsername));
 $checkEmail = mysqli_fetch_array(mysqli_query($con,$CheckSqlEmail));
 
 //caso username exista
 if(isset($checkUsername)){

	$result["sucesso"]="-1";
	$result["mensagem"]="O jogador $username já existe";
	echo json_encode($result);
 }
 
 //caso email exista
 else if(isset($checkEmail)){
	 $result["sucesso"]="-2";
	$result["mensagem"]="O jogador com o email $email já existe";
	echo json_encode($result);
 }
 //registar novo jogador
else{ 
$Sql_Query = "INSERT INTO jogador (nome, apelido, username, email, password) VALUES('$nome','$apelido',
'$username','$email','$hashed_password')";

//Handler para sucesso
 if(mysqli_query($con,$Sql_Query))
{
	$result["sucesso"]="1";
	$result["mensagem"]="Jogador Registado com sucesso! Efetue Login!";
	
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
 
?>