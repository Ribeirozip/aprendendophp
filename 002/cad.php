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
        <h1> Resultado do processamento </h1>
    </header>
    <main>
        <?php 
            //var_dump($_GET);
            // var_dump($_REQUEST); GET POST COoKIES
            $n = $_GET["nome"];
            $s = $_GET["snome"];
                echo"Prazer conhece-lo(a), <strong> $n $s</strong>! ";
        ?>
        <p> <a href="javascript:history.go(-1)" > Volta para pagina anterior </a> </p>
    </main>
    
</body>
</html>