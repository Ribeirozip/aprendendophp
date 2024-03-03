<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1> Resultado</h1>
    </header>
    <main>
        <?php 
           $inicio=date("m-d-Y", strtotime("-7 days"));
           $fim = date("m-d-Y"); 
           $url ='https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''.$inicio.'\'&@dataFinalCotacao=\''.$fim.'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';

           $dados = json_decode(file_get_contents($url), true);
          
           $cotacao = $dados["value"][0]["cotacaoCompra"];

           echo "A cotação é ". $cotacao;

            $real = $_REQUEST["numero"] ?? 0;

            $dolar= $real /$cotacao;
            $real_formatado = number_format($real, 2, ',', '.');
            $dolar_formatado = number_format($dolar, 2, '.', ',');
            
            echo "<p>Seus R$ {$real_formatado} equivalem a <strong>US$ {$dolar_formatado}</strong></p>"; 
        
                    
        ?>
        <button onclick="javascript:history.go(-1)">Voltar</button>
       
    </main>   
</body>
</html>