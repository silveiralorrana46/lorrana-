<?php
require_once "config/conexao.php";

// Busca os clientes mais recentes primeiro
$stmt = $pdo->query(
    "SELECT * FROM clientes ORDER BY id DESC"
);

$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gerenciamento de Clientes</title>

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >

    <!-- CSS principal -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <main class="container">

        <header class="page-header">
            <div class="header-info">
                <div class="header-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>
                    <h1>Clientes</h1>
                    <p>Gerencie seus clientes de forma simples e eficiente.</p>
                </div>
            </div>

            <a href="cadastro.php" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i>
                <span>Novo Cliente</span>
            </a>
        </header>

        <section class="content-card">

            <div class="table-header">
                <div>
                    <h2>Lista de clientes</h2>
                    <p>
                        <?= count($clientes) ?>
                        <?= count($clientes) === 1
                            ? 'cliente cadastrado'
                            : 'clientes cadastrados' ?>
                    </p>
                </div>

                <div class="table-header-icon">
                    <i class="fa-solid fa-address-book"></i>
                </div>
            </div>

            <div class="table-responsive">

                <table>
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Cidade</th>
                            <th class="actions-column">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (empty($clientes)): ?>

                            <tr>
                                <td colspan="4" class="empty-state">
                                    <i class="fa-solid fa-users-slash"></i>

                                    <strong>Nenhum cliente encontrado</strong>

                                    <span>
                                        Cadastre um novo cliente para começar.
                                    </span>

                                    <a href="cadastro.php" class="btn btn-primary">
                                        <i class="fa-solid fa-plus"></i>
                                        Cadastrar cliente
                                    </a>
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach ($clientes as $cliente): ?>

                                <tr>
                                    <td>
                                        <div class="client-name">
                                            <div class="client-avatar">
                                                <i class="fa-solid fa-user"></i>
                                            </div>

                                            <span>
                                                <?= htmlspecialchars(
                                                    $cliente["nome"],
                                                    ENT_QUOTES,
                                                    "UTF-8"
                                                ) ?>
                                            </span>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="client-email">
                                            <i class="fa-regular fa-envelope"></i>

                                            <?= htmlspecialchars(
                                                $cliente["email"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <span class="client-city">
                                            <i class="fa-solid fa-location-dot"></i>

                                            <?= htmlspecialchars(
                                                $cliente["cidade"],
                                                ENT_QUOTES,
                                                "UTF-8"
                                            ) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="action-buttons">

                                            <a
                                                href="editar.php?id=<?= (int) $cliente['id'] ?>"
                                                class="btn btn-edit"
                                                title="Editar cliente"
                                                aria-label="Editar cliente"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                <span>Editar</span>
                                            </a>

                                            <a
                                                href="excluir.php?id=<?= (int) $cliente['id'] ?>"
                                                class="btn btn-delete btn-excluir"
                                                title="Excluir cliente"
                                                aria-label="Excluir cliente"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                                <span>Excluir</span>
                                            </a>

                                        </div>
                                    </td>
                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>
                </table>

            </div>

            <footer class="card-footer">
                <span>
                    <i class="fa-solid fa-shield-halved"></i>
                    Sistema de gerenciamento de clientes
                </span>

                <span>
                    Total: <strong><?= count($clientes) ?></strong>
                </span>
            </footer>

        </section>

    </main>

    <script src="js/script.js"></script>

</body>
</html> 