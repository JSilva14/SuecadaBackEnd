<?php 
 
 //script para receber id do grupo que o jogador se encontra a visualizar atualmente
 if($_SERVER['REQUEST_METHOD']=='POST'){
 
 $uuid  = $_POST['uuid'];

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
 
 require_once('dbConnect.php');
 
 //Query para atualizar sessao

 $sql = "UPDATE sessao 
         SET pontuacao_jogador1 = $pontuacao1,
            pontuacao_jogador2 = $pontuacao2,
            pontuacao_jogador3 = $pontuacao3,
            pontuacao_jogador4 = $pontuacao4,
            pontuacao_jogador5 = $pontuacao5
         WHERE UUID = '".$uuid."' ";

$sql_update_event = "ALTER EVENT `".$uuid."`
                        ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL 1 HOUR
                        DO
                        UPDATE sessao, jogador 
                        SET sessao.flg_ativa = 0, jogador.flg_ingame=0 
                        WHERE sessao.UUID = '".$uuid."' 
                        AND (jogador.username='".$jogador1."' 
	                  OR jogador.username='".$jogador3."'
	                  OR jogador.username='".$jogador4."'
	                  OR jogador.username='".$jogador2."'
                        OR jogador.username='".$jogador5."') ";
                        
              
 //executar query de info utilizando conexao importada
 $r = mysqli_query($con,$sql);
 $r2 = mysqli_query($con,$sql_update_event);
 
 if($r and $r2){
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