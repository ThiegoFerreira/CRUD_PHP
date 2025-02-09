<?php

require '../Model/Database.php';

class Venda{

    public int $id_venda;
    public string $cliente;
    public string $produto;
    public int $quantidade;
    public float $valor;
    public string $vendedor;

    public function cadastrar(){
        //O comando abaixo instancia o banco e conecta com a tabela nele
        $db = new Database('venda');

        //chama a função insert do banco e passa o Array como parametro
        $res = $db->insert(
            [
                'cliente'=>$this->cliente,
                'produto'=>$this->produto,
                'quantidade'=>$this->quantidade,
                'valor'=>$this->valor,
                'vendedor'=>$this->vendedor,
            ]
            );
        return $res;    
    }

    public function buscar($where = null,$order = null,$limit = null){
        $db = new Database('venda'); 

        $res = $db->select($where,$order,$limit)->fetchAll(PDO::FETCH_CLASS,self::class);
        return  $res;
       
    }
    public function buscar_por_id($id){
        $db = new Database('venda'); 
        $where = 'id_venda ='.$id;
        $res = $db->select($where)->fetchObject(self::class);
        return  $res;        
    }

    public function atualizar(){
        $db = new Database('venda');
        $res = $db->update(
            'id_venda ='.$this->id_venda,
            [
                "cliente" => $this->cliente,
                "produto" => $this->produto,
                "quantidade" => $this->quantidade,
                "valor" => $this->valor,
                "vendedor" => $this->vendedor,
            ]
            );
            return $res;
    }


    public function excluir(){
        //O comando abaixo instancia o banco e conecta com a tabela nele
        $db = new Database('venda');
        $where = 'id_venda ='.$this->id_venda;//Instanciar o objeto com o ID de quem vai ser deletado
        $res = $db->delete($where); //Delete chamando a classe where que chamou o ID a ser deletado
        return $res->rowCount();
    }

}