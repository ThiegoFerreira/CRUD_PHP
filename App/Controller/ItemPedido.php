<?php

require_once '../Model/Database.php';

class ItemPedido {

    public int $id_item_pedido;
    public int $pedido_id;
    public int $produto_id;
    public int $quantidade;
    public float $preco_unitario;
    public float $preco_total;

    public function __construct(int $pedido_id, int $produto_id, int $quantidade) {
        $this->pedido_id = $pedido_id;
        $this->produto_id = $produto_id;
        $this->quantidade = $quantidade;
        $this->preco_unitario = 0; // Inicializando
        $this->preco_total = 0;    // Inicializando
    }

    public function cadastrar() {
        $dbProduto = new Database('produto');
        $dbItemPedido = new Database('item_pedido');

        // Verifica se o produto existe antes de cadastrar
        $produto = $dbProduto->select('id_produto = ' . $this->produto_id)->fetch(PDO::FETCH_ASSOC);

        if (!$produto) {
            throw new Exception("Erro: Produto ID {$this->produto_id} não encontrado.");
        }

        // Define os preços do item
        $this->preco_unitario = $produto['valor'];
        $this->preco_total = $this->quantidade * $this->preco_unitario;

        // Insere o item no banco
        return $dbItemPedido->insert([
            'pedido_id' => $this->pedido_id,
            'produto_id' => $this->produto_id,
            'quantidade' => $this->quantidade,
            'preco_unitario' => $this->preco_unitario,
            'preco_total' => $this->preco_total
        ]);
    }

    public function buscar($where = null, $order = null, $limit = null) {
        $db = new Database('item_pedido');
        return $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function buscar_por_id($id) {
        $db = new Database('item_pedido');
        $where = 'id_item_pedido = ' . $id;
        $res = $db->select($where)->fetchObject(self::class);

        if (!$res) {
            throw new Exception("Erro: ItemPedido ID {$id} não encontrado.");
        }

        return $res;
    }

    public function atualizar() {
        $db = new Database('item_pedido');
        return $db->update(
            'id_item_pedido = ' . $this->id_item_pedido,
            [
                'pedido_id' => $this->pedido_id,
                'produto_id' => $this->produto_id,
                'quantidade' => $this->quantidade,
                'preco_unitario' => $this->preco_unitario,
                'preco_total' => $this->preco_total
            ]
        );
    }

    public function excluir() {
        $db = new Database('item_pedido');
        return $db->delete('id_item_pedido = ' . $this->id_item_pedido);
    }
}
