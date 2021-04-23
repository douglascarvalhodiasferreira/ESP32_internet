<?php 
	
	include('conexao.php'); //inclui a pagina que inicia a conexão com o banco de dado
	
if(isset($_GET['sens_temp'])){ //verifica se tem solicitação no get
	
	

	$sensortemp = $_GET['sens_temp']; // armazena o que veio do get na variavel
	$dia=$_GET['d'];
	$mes=$_GET['m'];
	$ano=$_GET['a'];
	$hora=$_GET['h'];

	$data = date('d/m/Y H:i:s'); //variavel com um timestamp da data e hora
	

		$sql = "INSERT INTO temp_aqua (sens_temp, dia, mes, ano, hora) VALUES (:sens_temp, :dia, :mes, :ano, :hora)"; // acessa a tabela temp_aqua para armazenar o valor da temperatura

		$stmt = $PDO->prepare($sql);// manda preparar os dados para gravar

		$stmt->bindParam(':sens_temp',$sensortemp); //deixa o armazenamento no banco de dados mais seguro
		$stmt->bindParam(':dia',$dia);
		$stmt->bindParam(':mes',$mes);
		$stmt->bindParam(':ano',$ano);
		$stmt->bindParam(':hora',$hora);
		

		if($stmt->execute()){ //manda realizar a operação
			echo "<p>salvo_com_sucesso<br/>".$data."</p>"; //se gravado manda esse dado na tela e tbm retora para o esp
		}else{
			echo "<p>erro_ao_salvar<br/></p>";
		}
}
	
	//busca no BD o ultimo ID
	$stmt = $PDO->prepare("SELECT MAX(ID) FROM temp_aqua"); //seleciona o maior id da tabela temp_aqua
	$stmt->execute();
	
	$maxID = $stmt->fetchAll(); //pega os dados retornados

	$ult_result=$maxID[0]['MAX(ID)']; //grava o valor do maior id na variável

	//busca no BD a temperatura da ultima inserção
	$stmt = $PDO->prepare("SELECT sens_temp,data_hora FROM temp_aqua WHERE id='$ult_result'");//atravez do maior id seleciona a ultima temperatura e a ultima data armazenada
	$stmt->execute();

	$resultado = $stmt->fetchAll();
	
	$valortemp=($resultado[0]['sens_temp']);
	$valordata=($resultado[0]['data_hora']);

	$date = new DateTime($valordata);

	$dataA=$date->format('d/m/Y H:i:s');

	$result_arry=[$valortemp,$dataA];

	$JSON=json_encode($result_arry);
	//$JSON_data=json_encode($valordata);
	
	//echo $JSON_temperatura;
	echo $JSON;
	
	//echo $valor;

 ?>