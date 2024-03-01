<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Primeiro code</title>
</head>
<body>
    <h1>
        <?php 
            date_default_timezone_set("America/Sao_Paulo");
            echo "Hoje é dia" .date("d/M/y");
            echo "<p> horas são :</p>".date("G:i:s");
        ?>

    </h1>
    
</body>
</html>
