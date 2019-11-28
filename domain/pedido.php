<?php
class Pedido{
    public $id;
    public $id_cliente;
    public $data_pedido;
    

public function __construct($db){
    $this->conexao = $db;
}
/*Fução listar para selecionar todos os pedidos cadastrados no banco
de dados. Essa função retorna uma lista com todos os dados
 */
public function listar(){
    $query = "select * from pedido";
/*
Foi criada a variavel stmt para guardar a preparação da consulta select que será executada posteriomente
*/
    $stmt = $this->conexao->prepare($query);
    #execução da consulta e guarda de dados na variavel stmt
    $stmt->execute();
    #retorna os dados do usuario a camada data.
    return $stmt;
}
/*
Função para cadastrar os pedidos no banco de dados
*/
public function cadastro(){
    $query = "insert into pedido set id_cliente=:c";

    $stmt = $this->conexao->prepare($query);
/*
Foi utlizada 2 funções para tratar os dados que estão vindo do usuario
para a api.
strip_tag-> trata os dados em seus formatos inteiro, double ou decimal
htmlspecialchar -> retirar as aspas e os 2 pontos que vem do formato json
para cadastrar em banco
*/
    $this->id_cliente = htmlspecialchars (strip_tags($this->id_cliente));
    

    #encriptografar a senha 
    
    $stmt->bindParam(":c",$this->id_cliente);
    

    
    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}
public function alterarpedido(){
    $query = "update pedido set id_cliente=:c where id=:i";
    $stmt = $this-> conexao->prepare($query);
    $stmt->bindParam(":c",$this->id_cliente);
    $stmt->bindParam(":i",$this->id);
   
 

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function apagar(){
    $query = "delete from pedido where id=?";
    $stmt= $this->conexao->prepare($query);
    $stmt->bindParam(1,$this->id);
    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}



}

?>