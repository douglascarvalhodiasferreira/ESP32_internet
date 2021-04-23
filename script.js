//variaveis globais

var cano1;
var cano2;
var cano3;
var cano4;
var j_tempA;
entrada="";


alert("teste");


window.addEventListener("load", valor_cor);//ASSIM QUE CARREGAR A PAGINA CHAMA A FUNÇÃO valor_cor
    setInterval(valor_cor, 15000); //chama a função valor_cor de 15/15 segundos
      function valor_cor (){ //essa função pega do banco de dados da pagina salvart.php o valor da temperatura
        fetch('salvart.php').then(function(response) {
          response.json().then(function(data) {
          
          document.getElementById("vtemp").innerHTML=data[0]; //pega do array data o valor da temperatura e manda para a pagina html
          document.getElementById("ultimaA_t").innerHTML=data[1];//pega do array data a data-hora da ultima atualização e manda para a pagina html
          //console.log(result[1]); //Dados retornados pela API
        })
      })
      setTimeout(mudacortemp, 500); //chama a função mudacortemp toda vez que a função valor_cor é chamada
      }
       function mudacortemp(){ // Modifica a cor da div que mostra o valor da temperatura
          var temp = document.getElementById("temp"); 
          entrada = document.getElementById("vtemp").innerHTML;
            if(entrada>=30){
              temp.style.backgroundColor="#f00"; //muda a cor do backgroud da div que esta mostrando a temperatura
              temp.style.color="#fff"; //muda a cor das letras
              envia_json_telegram ('jst',entrada,'Temp_em_VERMELHO:'); // chama a função que manda msg para o telegram com os parametros para enviar por get
            }else if(entrada>=27){
              temp.style.backgroundColor="#ff0";
              temp.style.color="#000";
              envia_json_telegram ('jst',entrada,'Temp_em_Amarelo:');
            }else if(entrada>20&&entrada<27){
              temp.style.backgroundColor="green";
              temp.style.color="#fff";
            }else if(entrada<=20&&entrada>=17){
              temp.style.backgroundColor="#ff0";
              temp.style.color="#000";
              //console.log(j_tempA);
              envia_json_telegram ('jst',entrada,'Temp_em_Amarelo:');
            }else if(entrada<17){
              temp.style.backgroundColor="#f00";
              temp.style.color="#fff";
              envia_json_telegram ('jst',entrada,'Temp_em_VERMELHO:');
            }
           
        }


        setInterval(valor_cano, 15000); // chama a vunção valor_cano a cada 5 segundos
//valor_cano();
        function valor_cano (){ // função que pega os parametros do cano enviado pelo ESP para o banco de dados na pagina salvarc.php
          fetch('salvarc.php').then(function(response) { // pede uma resposta a pagina salvarc.php
          //var resposta = response[0][0];
          
            response.json().then(function(data) { //recebe os dados como array data
            
            cano1=data[0];
            cano2=data[1];
            cano3=data[2];
            cano4=data[3];
            var data_hora=data[4];

            document.getElementById("ultimaA_c").innerHTML=data_hora // manda para pagina a ultima atualização do banco de dados dos canos
            
            mudacano(); // chama a função que muda a cor dos ciculos indicativo se está passando ou não agua nos canos da pagina
          })
          })
        }

        function mudacano() { // verifica o estado dos canos e conforme o valor faz alterações na pagina
            if(cano1){
              var x = document.getElementById("cano1"); //pega o local do circulo para fazer alterações
              x.style.backgroundColor="#f00"; //modifica a cor do cirulo
              x.style.width="40px"; // se alterado aumenta a largura do circulo
              x.style.height="40px";// se alterado aumenta a altura do circulo
              envia_json_telegram ('jsc','ok','NAO_PASSA_AGUA_CANO1'); // chama a função que manda msg para o telegram com os parametros para enviar por get
            }else{
              var x = document.getElementById("cano1");
              x.style.backgroundColor="#00f";
              x.style.width="20px";
              x.style.height="20px";
            }     
            
            if(cano2){
              var x = document.getElementById("cano2");
              x.style.backgroundColor="#f00";
              x.style.width="40px";
              x.style.height="40px";
              envia_json_telegram ('jsc','ok','NAO_PASSA_AGUA_CANO2');
            }else{
              var x = document.getElementById("cano2");
              x.style.backgroundColor="#00f";
              x.style.width="20px";
              x.style.height="20px";
            } 

            if(cano3){
              var x = document.getElementById("cano3");
              x.style.backgroundColor="#f00";
              x.style.width="40px";
              x.style.height="40px";
              envia_json_telegram ('jsc','ok','NAO_PASSA_AGUA_CANO3');
            }else{
              var x = document.getElementById("cano3");
              x.style.backgroundColor="#00f";
              x.style.width="20px";
              x.style.height="20px";
            } 

            if(cano4){
              var x = document.getElementById("cano4");
              x.style.backgroundColor="#f00";
              x.style.width="40px";
              x.style.height="40px";
              envia_json_telegram ('jsc','ok','NAO_PASSA_AGUA_CANO4');
            }else{
              var x = document.getElementById("cano4");
              x.style.backgroundColor="#00f";
              x.style.width="20px";
              x.style.height="20px";
            } 
        }
      

function envia_json_telegram (URL,P,MSG){ //função responsável por madar as alterações para o telegram
  //console.log(EJSON);
  //var env_js= EJSON;
  
    var url = "telegram.php?"; // url da pagina php que manda msg para o telegram
    url +=URL+'='; //parametro com o nome do valor alterado para verificação por get na pagina telegram.php
    url +=P;// corpo do que está alterado
    url +='&msg='; // parametro verificador da msg para pagina do telegram
    url +=MSG;// a msg
    
    const options = {// constante que organiza a msg
        method: 'get',
        //body: JSON.stringify(dados),
        headers: {
            'Content-Type':'text/json'
        }
    }
    //console.log(options);
    fetch(url,options) // faz solicitação para pagina com os valores verificadores
        .then(res => res.json())
        .then(res => console.log(res)) // imprime no console a resposta de msg recebida da pg telegram
        .catch(erro => {console.log(erro)// se houver errp
        })
  }


 /*//window.addEventListener("load", drawChart);

  google.charts.load('current', {'packages':['gauge']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        
        var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['TEMPERATURA', 0],
          //['CPU', 55],
          //['Network', 68]
        ]);

        var options = {
          width: 500, height: 500,
          greenFrom:21, greenFrom: 26,
          yellowFrom:16, yellowTo: 30,
          redFrom: 0, redTo: 40,
          max: 40,
          majorTicks: 10,
          minorTicks: 10
        };

        var chart = new google.visualization.Gauge(document.getElementById('chart_div'));

        chart.draw(data, options);

        setInterval(function() {
          data.setValue(0, 1, entrada);
          chart.draw(data, options);
        }, 13000);
        
      }*/
