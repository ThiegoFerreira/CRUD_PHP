<?php
require_once '../Controller/Pedido.php';
require_once '../Controller/ItemPedido.php';
require_once '../Controller/Usuario.php';
require_once '../Controller/Produto.php';

$produto = new Produto();
$usuario = new Usuario();
$pedido = new Pedido();

$produtos = $produto->buscar();
$clientes = $usuario->buscar();
$pedidos = $pedido->buscar();



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_usuario'])) {
    try {
        // Criar Pedido
        $pedido = new Pedido($_POST['id_usuario']);
        $pedido_id = $pedido->cadastrar();

        // Adicionar Itens ao Pedido
        foreach ($_POST['produto_id'] as $index => $produto_id) {
            $quantidade = $_POST['quantidade'][$index];
            $item = new ItemPedido($pedido_id, $produto_id, $quantidade);
            $item->cadastrar();
        }

        header("Location: " . $_SERVER['PHP_SELF'] . "?sucesso=1");
        exit();
    } catch (Exception $e) {
        echo "Erro: " . $e->getMessage();
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Erro: ID do usuário não informado!";
}
?>



<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Pedido</title>
    <link rel="stylesheet" href="../../public/assets/css/style-vendas.css">
</head>
<body>
<?php if (isset($_GET['sucesso'])):
    echo "<script>
            alert('Venda realizada com sucesso!');
            window.location.href = venda.php;
            </script>";
endif; ?>
    <a href="../../index.php"><h2>VOLTAR</h2></a><br>
    <div class="titulo-container">
        <h2>Cadastrar Pedido</h2>
    </div>

    <div class="conteudo">
        <div class="container">
            
            <div class="form-box">
                <form action="venda.php" method="post">
                    <label>Cliente ID:</label><br>
                    <input type="number" name="id_usuario" required><br><br>

                    <h2>Itens do Pedido</h2>
                    <div id="itens-container">
                        <div class="item">
                            <label>Produto ID:</label>
                            <input type="number" name="produto_id[]" required>
                            
                            <label>Quantidade:</label>
                            <input type="number" name="quantidade[]" required min="1">
                        </div>
                    </div>

                    <button type="button" onclick="adicionarItem()">Adicionar Novo Item</button><br><br>

                    <input type="submit" value="Cadastrar Pedido">
                </form>
            </div>
        </div>

        <!-- Novo container para agrupar as tabelas -->
        <div class="tabelas-container">
            <!-- Tabela de Clientes -->
            <div class="tabela-container">
                <h2>LISTA DE CLIENTES</h2>
                <div class="tabela-box">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($clientes)): ?>
                                <?php foreach ($clientes as $cliente): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($cliente['id_usuario']) ?></td>
                                        <td><?= htmlspecialchars($cliente['nome']) ?></td>
                                        <td><?= htmlspecialchars($cliente['email']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="msg-vazio">Nenhum cliente encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Tabela de Produtos -->
            <div class="tabela-container">
                <h2>LISTA DE PRODUTOS</h2>
                <div class="tabela-box">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>NOME</th>
                                <th>DESCRIÇÃO</th>
                                <th>QUANTIDADE</th>
                                <th>VALOR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($produtos)): ?>
                                <?php foreach ($produtos as $prod): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($prod['id_produto']) ?></td>
                                        <td><?= htmlspecialchars($prod['nome']) ?></td>
                                        <td><?= htmlspecialchars($prod['descricao']) ?></td>
                                        <td><?= htmlspecialchars($prod['quantidade']) ?></td>
                                        <td><?= htmlspecialchars($prod['valor']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="msg-vazio">Nenhum produto encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tabela-container">
                <h2>LISTA DE PEDIDOS</h2>
                <div class="tabela-box">
                    <table class="tabela-clientes">
                        <thead>
                            <tr>
                                <th>ID Pedido</th>
                                <th>ID Cliente</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($pedidos)): ?>
                                <?php foreach ($pedidos as $pedido): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($pedido['id_pedido']) ?></td>
                                        <td><?= htmlspecialchars($pedido['id_usuario']) ?></td>
                                        <td><?= htmlspecialchars($pedido['data_pedido']) ?></td>
                                        <td><?= htmlspecialchars($pedido['status']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="msg-vazio">Nenhum pedido encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script>
        function adicionarItem() {
            let container = document.getElementById("itens-container");
            let div = document.createElement("div");
            div.classList.add("item");
            div.innerHTML = `
                <label>Produto ID:</label>
                <input type="number" name="produto_id[]" required>
                
                <label>Quantidade:</label>
                <input type="number" name="quantidade[]" required min="1">
                
                <button type="button" onclick="removerItem(this)">Remover</button>
            `;
            container.appendChild(div);
        }

        function removerItem(button) {
            button.parentElement.remove();
        }
    </script>

</body>
</html>