<?php
	
			$HOST ="localhost";
			$BANCO = "esp32_casa";
			$USUARIO = "root";
			$SENHA = "";
	try {
			$PDO = new PDO("mysql:host=$HOST;dbname=$BANCO;charset=utf8", $USUARIO, $SENHA);

			//$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}catch (PDOExeption $erro){

			//echo "Erro de conexao, detalhes: " . $erro->getMenssage();
			echo "conexao_erro";

	}
  ?>