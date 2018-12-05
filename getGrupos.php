<?php 
 
 if($_SERVER['REQUEST_METHOD']=='POST'){
 //Receber valores via POST
 $idJogador = $_POST['idJogador'];
 
 //Criar query para encontrar info dos grupos a que o jogador logado pertence
 $sql = "SELECT g.nome as nome, COUNT(*) as num_jogadores, y.flg_admin as flg_admin
FROM jogador_grupo x 
JOIN `grupo` g ON x.id_grupo=g.id 
JOIN jogador_grupo y ON y.id_grupo = x.id_grupo
WHERE y.id_jogador = '$idJogador'
GROUP BY x.id_grupo
ORDER BY flg_admin desc, nome asc";


 
 //importar script de conexão
 require_once('dbConnect.php');
 
 //executar query
 $r = mysqli_query($con,$sql);
 
if (!$r)
{ 
	$resultStatus = array('Status'=>array('sucesso' => 0,
		'mensagem' => "Erro de conexão!"));
    echo json_encode($resultStatus);
}
else
{
	$count=mysqli_num_rows($r);
	if($count>0)
	{
		$resultStatus = array('Status'=>array('sucesso' => 1,
		'mensagem' => utf8_encode("sucesso")));
		
		$tempArray=array();
		while ($row=mysqli_fetch_array($r))
		{
			array_push($tempArray,array(
			'nomeGrupo' => utf8_encode($row["nome"]),
			'flgAdmin' => utf8_encode($row["flg_admin"]),
			'numJogadores' => utf8_encode($row["num_jogadores"])));
		}
		$resultGrupos=array('Grupos'=>$tempArray);
		
		echo json_encode(array_merge($resultStatus,$resultGrupos));
	}
	else{
		$resultStatus = array('Status'=>array('sucesso' => 2,
		'mensagem' => "Sem Grupos!"));
		echo json_encode($resultStatus);
	}
}

 }
mysqli_close($con);