<?php

require_once '../Model/Database.php';

class Pedido {
    public int $id_pedido;
    public int $id_usuario;
    public string $status;
    public string $data_pedido;

    public function __construct(int $id_usuario, string $status = 'pendente') {
        $this->id_usuario = $id_usuario;
        $this->status = $status;
    }

    public function cadastrar() {
        $db = new Database('pedido');
        $dbUsuario = new Database('usuario');

        // Verifica se o usuário existe na tabela correta
        $usuarioExiste = $dbUsuario->select("id_usuario = " . intval($this->id_usuario))->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuarioExiste) {
            throw new Exception("Erro: Usuário ID {$this->id_usuario} não encontrado.");
        }

        // Insere o pedido no banco
        $res = $db->insert([
            'id_usuario' => $this->id_usuario, 
            'status' => $this->status,
        ]);

        if (!$res) {
            throw new Exception("Erro ao inserir o pedido.");
        }

        return $res;
    }

    public function buscar($where = null, $order = null, $limit = null) {
        $db = new Database('pedido'); 
        return $db->select($where, $order, $limit)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscar_por_id($id) {
        $db = new Database('pedido');
        $where = 'id_pedido = '.$id;
        $res = $db->select($where)->fetchObject(self::class);

        if (!$res) {
            throw new Exception("Pedido ID {$id} não encontrado.");
        }

        return $res;
    }

    public function atualizar() {
        $db = new Database('pedido');
        $dbUsuario = new Database('usuario');

        // Verifica se o usuário informado existe antes de atualizar
        $usuarioExiste = $dbUsuario->select("id_usuario = " . intval($this->id_usuario))->fetch(PDO::FETCH_ASSOC);
        
        if (!$usuarioExiste) {
            throw new Exception("Erro: Usuário ID {$this->id_usuario} não encontrado.");
        }

        return $db->update(
            'id_pedido = ' . $this->id_pedido,
            [
                'id_usuario' => $this->id_usuario,
                'status' => $this->status,
            ]
        );
    }

    public function excluir() {
        $db = new Database('pedido');
        return $db->delete('id_pedido = ' . $this->id_pedido);
    }
}