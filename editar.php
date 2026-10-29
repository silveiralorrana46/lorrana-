<?php
require_once "config/conexao.php";

// Recebe e valida o ID pela URL.
$idRecebido = $_GET["id"] ?? null;

$id = filter_var($idRecebido, FILTER_VALIDATE_INT);

if ($id === false || $id === null || $id < 1) {
    http_response_code(400);
    exit("Cliente não informado ou ID inválido.");
}

// Busca o cliente no banco de dados.
$stmt = $pdo->prepare(
    "SELECT id, nome, email, telefone, cidade
     FROM clientes
     WHERE id = :id"
);

$stmt->execute([":id" => $id]);

$cliente = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$cliente) {
    http_response_code(404);
    exit("Cliente não encontrado.");
}

// Protege os valores exibidos no HTML.
function escapar($valor)
{
    return htmlspecialchars(
        (string) ($valor ?? ""),
        ENT_QUOTES,
        "UTF-8"
    );
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Editar Cliente</title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    <!-- Estilos do sistema -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<main class="container">

    <header class="page-header">

        <div class="header-info">

            <div class="header-icon">
                <i class="fa-solid fa-user-pen"></i>
            </div>

            <div>
                <h1>Editar Cliente</h1>
                <p>Atualize os dados cadastrais do cliente.</p>
            </div>

        </div>

        <a href="index.php" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i>
            Voltar à lista
        </a>

    </header>

    <section class="content-card">

        <div class="table-header">

            <div>
                <h2>Informações do cliente</h2>
                <p>Confira os dados antes de salvar as alterações.</p>
            </div>

            <div class="table-header-icon">
                <i class="fa-solid fa-address-card"></i>
            </div>

        </div>

        <div class="form-container">

            <form method="POST" action="atualizar.php">

                <!-- O ID é obrigatório para localizar o registro. -->
                <input
                    type="hidden"
                    name="id"
                    value="<?= (int) $cliente["id"] ?>"
                >

                <div class="form-grid">

                    <div class="form-group">
                        <label for="nome">
                            <i class="fa-solid fa-user"></i>
                            Nome completo
                        </label>

                        <input
                            type="text"
                            id="nome"
                            name="nome"
                            value="<?= escapar($cliente["nome"]) ?>"
                            maxlength="150"
                            autocomplete="name"
                            placeholder="Digite o nome completo"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="email">
                            <i class="fa-solid fa-envelope"></i>
                            E-mail
                        </label>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="<?= escapar($cliente["email"]) ?>"
                            maxlength="254"
                            autocomplete="email"
                            placeholder="exemplo@email.com"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label for="telefone">
                            <i class="fa-solid fa-phone"></i>
                            Telefone
                        </label>

                        <input
                            type="tel"
                            id="telefone"
                            name="telefone"
                            value="<?= escapar($cliente["telefone"]) ?>"
                            maxlength="30"
                            autocomplete="tel"
                            placeholder="Digite o telefone"
                        >
                    </div>

                    <div class="form-group">
                        <label for="cidade">
                            <i class="fa-solid fa-location-dot"></i>
                            Cidade
                        </label>

                        <input
                            type="text"
                            id="cidade"
                            name="cidade"
                            value="<?= escapar($cliente["cidade"]) ?>"
                            maxlength="100"
                            autocomplete="address-level2"
                            placeholder="Digite a cidade"
                        >
                    </div>

                </div>

                <div class="form-notice">
                    <i class="fa-solid fa-circle-info"></i>
                    Os campos Nome e E-mail são obrigatórios.
                </div>

                <div class="form-actions">

                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Salvar alterações
                    </button>

                    <a href="index.php" class="btn btn-secondary">
                        <i class="fa-solid fa-xmark"></i>
                        Cancelar
                    </a>

                </div>

            </form>

        </div>

    </section>

</main>

<script src="js/script.js"></script>

</body>
</html>