<?php
require_once '../Model/Database.php';

class Produto{

    public int $id_produto;
    public string $nome;
    public string $descricao;
    public int $quantidade;
    public float $valor;

    public function cadastrar(){
        //O comando abaixo instancia o banco e conecta com a tabela nele
        $db = new Database('produto');

        //chama a função insert do banco e passa o Array como parametro
        $res = $db->insert(
            [
                'nome'=>$this->nome,
                'descricao'=>$this->descricao,
                'quantidade'=>$this->quantidade,
                'valor'=>$this->valor,
            ]
            );
        return $res;    
    }

    public function buscar($where = null,$order = null,$limit = null){
        $db = new Database('produto'); 

        $res = $db->select($where,$order,$limit)->fetchAll(PDO::FETCH_ASSOC);
        return  $res;
       
    }
    public function buscar_por_id($id){
        $db = new Database('produto'); 
        $where = 'id_produto ='.$id;
        $res = $db->select($where)->fetchObject(self::class);
        return  $res;        
    }

    public function atualizar(){
        $db = new Database('produto');
        $res = $db->update(
            'id_produto ='.$this->id_produto,
            [
                "nome" => $this->nome,
                "descricao" => $this->descricao,
                "quantidade" => $this->quantidade,
                "valor" => $this->valor,
            ]
            );
            return $res;
    }


    public function excluir(){
        //O comando abaixo instancia o banco e conecta com a tabela nele
        $db = new Database('produto');
        $where = 'id_produto ='.$this->id_produto;//Instanciar o objeto com o ID de quem vai ser deletado
        $res = $db->delete($where); //Delete chamando a classe where que chamou o ID a ser deletado
        return $db->delete($where);
    }

}