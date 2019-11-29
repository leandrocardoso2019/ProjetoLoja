<?php
class Detalhepedido{
    public $id;
    public $id_cliente;
    public $id_produto;
    public $quantidade;
    

public function __construct($db){
    $this->conexao = $db;
}
/*Fução listar para selecionar todos os detalhepedidos cadastrados no banco
de dados. Essa função retorna uma lista com todos os dados
 */
public function listar(){
    $query = "select * from detalhepedido";
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
Função para cadastrar os detalhepedidos no banco de dados
*/
public function cadastro(){
    $query = "insert into detalhepedido set id_pedido=:p, id_produto=:o,quantidade=:q";

    $stmt = $this->conexao->prepare($query);
/*
Foi utlizada 2 funções para tratar os dados que estão vindo do usuario
para a api.
strip_tag-> trata os dados em seus formatos inteiro, double ou decimal
htmlspecialchar -> retirar as aspas e os 2 pontos que vem do formato json
para cadastrar em banco
*/
    $this->id_pedido = htmlspecialchars (strip_tags($this->id_pedido));
    $this->id_produto = htmlspecialchars (strip_tags($this->id_produto));
    $this->quantidade = htmlspecialchars (strip_tags($this->quantidade));
    

    #encriptografar a senha 
    
    $stmt->bindParam(":p",$this->id_pedido);
    $stmt->bindParam(":o",$this->id_produto);
    $stmt->bindParam(":q",$this->quantidade);
    

    
    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}
public function alterardetalhepedido(){
    $query = "update detalhepedido id_pedido=:p, id_produto=:o,quantidade=:q where id=:i";
    $stmt = $this-> conexao->prepare($query);
    $stmt->bindParam(":p",$this->id_pedido);
    $stmt->bindParam(":o",$this->id_produto);
    $stmt->bindParam(":q",$this->quantidade);
    $stmt->bindParam(":i",$this->id);
   
 

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function apagar(){
    $query = "delete from detalhepedido where id=?";
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