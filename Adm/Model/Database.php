<?php

//Classe Database (CRUD):______________________________________________________________
class Database{
    private $conn;
    private string $local = 'localhost';
    private string $db = 'HypertextPreprocessor';
    private string $user = 'root';
    private string $password = '';
    private string $table;


    //Método construtor da classe Database:___________________________________________
    function __construct($table = null){
        $this->table = $table;
        $this->conecta();
    }


    //Função de conectar no Data Base:________________________________________________
    private function conecta(){
        try{
            $this->conn = new PDO("mysql:host=".$this->local.";dbname=".$this->db,$this->user,$this->password);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            echo "Conectado com sucesso";
        
        }
        catch(PDOException $err){
            die("Connection Failed".$err->getMessage());
        }
    }


    //Função de executar (preparar e executar as querys):_____________________________
    public function execute($query, $binds = []){
        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute($binds);
            return $stmt;
        }
        catch(PDOExcepetion$err){
            die("Connection Failed".$err->getMessage());
        }
    }


    // //Função para logar no sistema:
    // public function logar($values){
    //     $fields = array_keys($values);
    //     $param = array_values($values);

    //     $query 
    // }


    //Função para inserir dados em tabelas: __________________________________________
    public function insert($values){//$Values = Array associativa
        $fields = array_keys($values);//Separa as keys da array e cria nova array.
        $param = array_values($values);//Separa os valores associados as keys e cria nova array.
        $binds = array_pad([],count($fields),'?');//conta o número de keys e cria nova array com binds'?'.
        
        $query = 'INSERT INTO '.$this->table. ' ('.implode(',',$fields).') VALUES ('.implode(',',$binds).')';//Monta a query para o insert construindo com binds.

        $res = $this->execute($query,$param);

        if ($res){
            return true;
        }else{
            return false;
        }
    }


    //Função para selecionar (select) dados do db:______________________________________
    public function select($where = null, $order = null, $limit = null, $fields = '*'){
        $where = strlen($where) ? 'WHERE '.$where : '';
        $order = strlen($order) ? 'ORDER BY '.$order : '';
        $where = strlen($limit) ? 'LIMIT '.$limit : '';

        $query = 'SELECT '.$fields.' FROM '.$this->table.' '.$where;

        return $this->execute($query);

    }


    //Função para realizar update em dados presentes no db:______________________________
    public function update($where,$values){
        $fields = array_keys($values);
        $param = array_values($values);

        $query = 'UPDATE '.$this->table.' SET '.implode('=?,',$fields).'=? WHERE '.$where;

        $res = $this->execute($query,$param);
        
        if($res){
            return true;
        }
    }


    //Função para deletar dados do bd:________________________________________________
    public function delete($where){
        $query = 'DELETE FROM '.$this->table.' WHERE '.$where;
        $res = $this->execute($query);
    
        if($res->rowCount()>0){
            return true;
        }else{
            return false;
        }
    
    }

    





}