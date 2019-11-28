<?php
class Produto{
    public $id;
    public $descricao;
    public $preco;
    public $imagem1;
    public $imagem2;
    public $imagem3;
    public $imagem4;

    

public function __construct($db){
    $this->conexao = $db;
}
/*Fução listar para selecionar todos os produtos cadastrados no banco
de dados. Essa função retorna uma lista com todos os dados
 */
public function listar(){
    $query = "select * from produto";
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
Função para cadastrar os produtos no banco de dados
*/
public function cadastro(){
    $query = "insert into produto set nome=:n, descricao=:d, preco=:p, imagem1=:i1,imagem=:i2, imagem3=:i3, imagem=:i4";

    $stmt = $this->conexao->prepare($query);
/*
Foi utlizada 2 funções para tratar os dados que estão vindo do usuario
para a api.
strip_tag-> trata os dados em seus formatos inteiro, double ou decimal
htmlspecialchar -> retirar as aspas e os 2 pontos que vem do formato json
para cadastrar em banco
*/
    $this->nome = htmlspecialchars (strip_tags($this->nome));
    $this->descricao = htmlspecialchars (strip_tags($this->descricao));
    $this->preco = htmlspecialchars (strip_tags($this->preco));
    $this->imagem1 = htmlspecialchars (strip_tags($this->imagem1));
    $this->imagem2 = htmlspecialchars (strip_tags($this->imagem2));
    $this->imagem3 = htmlspecialchars (strip_tags($this->imagem3);
    $this->imagem4 = htmlspecialchars (strip_tags($this->imagem4));

    #encriptografar a senha 
    
    $stmt->bindParam(":n",$this->nome);
    $stmt->bindParam(":d",$this->descricao);
    $stmt->bindParam(":p",$this->preco);
    $stmt->bindParam(":i1",$this->imagem1);
    $stmt->bindParam(":i2",$this->imagem2);
    $stmt->bindParam(":i3",$this->imagem3);
    $stmt->bindParam(":i4",$this->imagem4);

    
    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}
public function alterarproduto(){
    $query = "update produto set nome=:n, descricao=:d, preco=:p, imagem1=:i1,imagem=:i2, imagem3=:i3, imagem=:i4 where id=:i";
    $stmt = $this-> conexao->prepare($query);
    $stmt->bindParam(":n",$this->nome);
    $stmt->bindParam(":d",$this->descricao);
    $stmt->bindParam(":p",$this->preco);
    $stmt->bindParam(":i1",$this->imagem1);
    $stmt->bindParam(":i2",$this->imagem2);
    $stmt->bindParam(":i3",$this->imagem3);
    $stmt->bindParam(":i4",$this->imagem4);
    $stmt->bindParam(":i",$this->id);

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function apagar(){
    $query = "delete from produto where id=?";
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