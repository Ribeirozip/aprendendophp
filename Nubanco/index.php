<?php
session_start();

// Conexão com o banco de dados (substitua os valores conforme necessário)
$servername = "localhost";
$username = "root";
$password = "";
$database = "ex";

$conn = new mysqli($servername, $username, $password, $database);

// Função para gerar um token CSRF
function generateCSRFToken() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = md5(uniqid(rand(), true));
    }
    return $_SESSION['csrf_token'];
}

// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar se o token CSRF está presente e é válido
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        // Token válido, processar os dados do formulário
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
        $query_update = "UPDATE saldo SET valor = $saldo_novo";
        $conn->query($query_update);

        // Exibe mensagem de sucesso
        echo "<p class='mensagem'>Novo saldo: R$ $saldo_novo</p>";

        // Redefinir o token após processar o formulário, para evitar reutilização
        unset($_SESSION['csrf_token']);
    } else {
        // Token inválido, exibir mensagem de erro
        echo "<p class='mensagem'>Token CSRF inválido!</p>";
    }
}

// Gerar o token CSRF
$csrfToken = generateCSRFToken();

// Fecha a conexão com o banco de dados
$conn->close();
?>

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
        <h2>Sua Conta</h2>
        
        <!-- Formulário para adicionar ou retirar dinheiro -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="csrf_token" value="<?php echo $csrfToken; ?>">
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
