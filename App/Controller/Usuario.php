<?php
require_once '../Model/Database.php';

class Usuario{

    public int $id_usuario;
    public string $nome;
    public string $email;
    public string $telefone;

    public function cadastrar(){
        //O comando abaixo instancia o banco e conecta com a tabela nele
        $db = new Database('usuario');

        //chama a função insert do banco e passa o Array como parametro
        $res = $db->insert(
            [
                'nome'=>$this->nome,
                'email'=>$this->email,
                'telefone'=>$this->telefone,
            ]
            );
        return $res;    
    }

    public function buscar($where = null,$order = null,$limit = null){
        $db = new Database('usuario'); 

        $res = $db->select($where,$order,$limit)->fetchAll(PDO::FETCH_ASSOC);
        return  $res;
       
    }
    public function buscar_por_id($id){
        $db = new Database('usuario'); 
        $where = 'id_usuario ='.$id;
        $res = $db->select($where)->fetchObject(self::class);
        return  $res;        
    }

    public function atualizar(){
        $db = new Database('usuario');
        $res = $db->update(
            'id_usuario ='.$this->id_usuario,
            [
                "nome" => $this->nome,
                "email" => $this->email,
                "telefone" => $this->telefone,
            ]
            );
            return $res;
    }


    public function excluir(){
        //O comando abaixo instancia o banco e conecta com a tabela nele
        $db = new Database('usuario');
        $where = 'id_usuario ='.$this->id_usuario;//Instanciar o objeto com o ID de quem vai ser deletado
        $res = $db->delete($where); //Delete chamando a classe where que chamou o ID a ser deletado
        return $db->delete($where);
    }

}