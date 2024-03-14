<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar/Retirar Dinheiro</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Adicionar/Retirar Dinheiro</h2>
        <?php
        // Conexão com o banco de dados (substitua os valores conforme necessário)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "ex";

        $conn = new mysqli($servername, $username, $password, $database);

        // Verifica se a conexão foi estabelecida corretamente
        if ($conn->connect_error) {
            die("Erro de conexão com o banco de dados: " . $conn->connect_error);
        }

        // Verifica se o formulário foi submetido
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtém os dados do formulário
            $valor = $_POST["valor"];
            $operacao = $_POST["operacao"];

            // Recupera o saldo atual do banco de dados
            $query = "SELECT valor FROM saldo";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $saldo_atual = $row["valor"];
            } else {
                $saldo_atual = 0;
            }

            // Atualiza o saldo com base na operação selecionada
            if ($operacao == "adicionar") {
                $saldo_novo = $saldo_atual + $valor;
            } elseif ($operacao == "retirar") {
                $saldo_novo = $saldo_atual - $valor;
            }

            // Atualiza o saldo no banco de dados
            $query = "UPDATE saldo SET valor = $saldo_novo";
            $conn->query($query);

            // Exibe o saldo atualizado
            echo "<p>Saldo Atual: R$ $saldo_novo</p>";
        }
        
        // Fecha a conexão com o banco de dados
        $conn->close();
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="valor">Valor:</label>
            <input type="number" id="valor" name="valor" required>
            <label for="operacao">Operação:</label>
            <select id="operacao" name="operacao" required>
                <option value="adicionar">Adicionar</option>
                <option value="retirar">Retirar</option>
            </select>
            <button type="submit">Enviar</button>
        </form>
    </div>
</body>
</html>
