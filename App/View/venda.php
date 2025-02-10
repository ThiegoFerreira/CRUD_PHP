<?php
require_once '../Controller/Pedido.php';
require_once '../Controller/ItemPedido.php';

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
</head>
<body>
<?php if (isset($_GET['sucesso'])): ?>
    <p style="color: green;">Pedido cadastrado com sucesso!</p>
<?php endif; ?>
    <h2>Cadastrar Pedido</h2>
    <form action="venda.php" method="post">
        <label>Cliente ID:</label><br>
        <input type="number" name="id_usuario" required><br><br>

        <h3>Itens do Pedido</h3>
        <div id="itens-container">
            <div class="item">
                <label>Produto ID:</label>
                <input type="number" name="produto_id[]" required>
                
                <label>Quantidade:</label>
                <input type="number" name="quantidade[]" required min="1">
            </div>
        </div>

        <button type="button" onclick="adicionarItem()">Adicionar Item</button><br><br>

        <input type="submit" value="Cadastrar Pedido">
    </form>

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