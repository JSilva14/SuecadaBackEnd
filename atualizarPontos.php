<?php
 
 $grupo = urldecode($_POST['grupo']);
 
 $jogador1 = urldecode($_POST['jogador1']);
 $jogador2 = urldecode($_POST['jogador2']);
 $jogador3 = urldecode($_POST['jogador3']);
 $jogador4 = urldecode($_POST['jogador4']);
 $jogador5 = urldecode($_POST['jogador5']);
  
 $pontuacao1 = urldecode($_POST['pontuacao1']);
 $pontuacao2 = urldecode($_POST['pontuacao2']);
 $pontuacao3 = urldecode($_POST['pontuacao3']);
 $pontuacao4 = urldecode($_POST['pontuacao4']);
 $pontuacao5 = urldecode($_POST['pontuacao5']);
 
 if($jogador1 == '' || $jogador2 == '' || $jogador3 == '' || $jogador4 == '' || $jogador5 == ''
 || $pontuacao1 == '' || $pontuacao2 == '' || $pontuacao3 == '' || $pontuacao4 == '' || $pontuacao5 == ''){
 echo 'Não existem dados para atualizar';
 }else{
 require_once('dbConnect.php');
 $sql = "INSERT INTO jogador_grupo VALUES ('$grupo','$jogador1','$pontuacao1')";
 $sql = "INSERT INTO jogador_grupo VALUES ('$grupo','$jogador2','$pontuacao2')";
 $sql = "INSERT INTO jogador_grupo VALUES ('$grupo','$jogador3','$pontuacao3')";
 $sql = "INSERT INTO jogador_grupo VALUES ('$grupo','$jogador4','$pontuacao4')";
 $sql = "INSERT INTO jogador_grupo VALUES ('$grupo','$jogador5','$pontuacao5')";
 
 if(mysqli_query($con,$sql)){
 echo 'Pontuações atualizadas';
 }else{
 echo 'Ocorreu um erro';
 }
 }
 mysqli_close($con);
 
 
 ?>