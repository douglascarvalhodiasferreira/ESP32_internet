<?php  

//require_once "./vendor/autoload.php"; // arquivos composer


include('conexao.php'); //inclui o inicio da conexão com o banco de dado

if (isset($_GET['v'])) {//se receber o verificador pega as variaveis

	$data = date('d/m/Y H:i:s'); //variavel com um timestamp da data e hora

	$cano1 = $_GET['cano1'];
	$cano2 = $_GET['cano2'];
	$cano3 = $_GET['cano3'];
	$cano4 = $_GET['cano4'];

	$dia=$_GET['d'];
	$mes=$_GET['m'];
	$ano=$_GET['a'];
	$hora=$_GET['h'];


$sql = "INSERT INTO pass_agua (cano1, cano2, cano3, cano4, dia, mes, ano, hora) VALUES (:cano1, :cano2, :cano3, :cano4, :dia, :mes, :ano, :hora)";

	$stmt = $PDO->prepare($sql);

	$stmt->bindParam(':cano1',$cano1);
	$stmt->bindParam(':cano2',$cano2);
	$stmt->bindParam(':cano3',$cano3);
	$stmt->bindParam(':cano4',$cano4);

	$stmt->bindParam(':dia',$dia);
	$stmt->bindParam(':mes',$mes);
	$stmt->bindParam(':ano',$ano);
	$stmt->bindParam(':hora',$hora);

	if($stmt->execute()){
		echo "<p>salvo_com_sucesso<br/>".$data."</p>";
	}else{
		echo "<p>erro_ao_salvar<br/></p>";
	}
	
}

//busca no BD o ultimo ID
$sql="SELECT MAX(ID) FROM pass_agua";
$stmt = $PDO->prepare($sql);
$stmt->execute();

$maxID = $stmt->fetchAll();

$ult_result=$maxID[0]['MAX(ID)'];
//echo($ult_result);

//busca no BD a temperatura da ultima inserção
$stmt = $PDO->prepare("SELECT cano1,cano2,cano3,cano4,data_hora FROM pass_agua WHERE id='$ult_result'");
$stmt->execute();

$resultado = $stmt->fetchAll();
//print_r($temperatura);

$rcano1= $resultado[0]['cano1'];
$rcano2= $resultado[0]['cano2'];
$rcano3= $resultado[0]['cano3'];
$rcano4= $resultado[0]['cano4'];
$rdata_hora=$resultado[0]['data_hora'];


$date = new DateTime($rdata_hora);

$dataA=$date->format('d/m/Y H:i:s');

$valor = [$rcano1,$rcano2,$rcano3,$rcano4,$dataA];


$JSON_cano=json_encode($valor);

printf($JSON_cano);

?>