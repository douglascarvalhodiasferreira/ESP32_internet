<?php
	
	//variaveis
	
	$T_JS = $_GET['jst'];
	$C_JS = $_GET['jsc'];
	$MSG_JS = $_GET['msg'];

	
	if(isset($T_JS)){
		$MsG = "Temperatura";
		msg_recebida($MsG);
		Envia_MSG($MSG_JS,$T_JS,"ºC");
	}
	if(isset($C_JS)){
		msg_recebida($MSG_JS);
		Envia_MSG($MSG_JS,$C_JS,".");
	}



	function msg_recebida($resp_msg){
		$respostaJS= ["Mensagem ".$resp_msg." recebida!"];
		echo json_encode($respostaJS);
	}
	
	//if(isset($rec_t_JSON)){}

	function Envia_MSG($mensagem,$valor,$unmed){

	//$HTML_alt = json_decode($rec_t_JSON);

	//echo (var_dump($rec_t_JSON));

			$MSG=$mensagem." ".$valor." ".$unmed;


			$token='1548488151:AAFn_YerTe7vGWsNP8i_d29t35RixPtOe2I';
			$grupo=927209657;

			$parametros['chat_id']=$grupo;
			$parametros['text']=$MSG;
			// PARA ACEITAR TAGS HTML
			//$parametros['parse_mode']=$HTML_alt[0]; 
			// PARA NÃO MOSTRAR O PREVIW DE UM LINK
			$parametros['disable_web_page_preview']=true; 

			$options = array(
				'http' => array(
				'method'  => 'POST',
				'content' => json_encode($parametros),
				'header'=>  "Content-Type: application/json\r\n" .
							"Accept: application/json\r\n"
				)
			);

			$context  = stream_context_create( $options );
			file_get_contents('https://api.telegram.org/bot'.$token.'/sendMessage', false, $context );
				

			}	


?>