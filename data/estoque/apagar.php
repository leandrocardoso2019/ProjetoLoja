<?php
/*
Vamos construir os cabeçalhos para o trabalho com a api
*/
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=utf-8");
#Esse cabeçalho define o metodo de envio como DELETE, ou seja, como deletar
header("Access-Control-Allow-Methods:DELETE");
#define o tempo d espera da api. Neste caso é 1 minuto
header("Accesss-Control-MAx-Age-3600");

include_once "../../config/database.php";
include_once "../../domain/estoque.php";

$database = new Database();
$db = $database->getConnection();

$estoque = new Estoque($db);
/*
O cliente irá enviar os dados no formato json. Porém nós precisamos dos dados no 
formato php para deletar em banco de dados. Para realizar essa conversão 
iremos usar o comando json_decode. Assim que o cliente enviar os dados, estes são
lidos pelo entrada php: e seu conteudo é capturado e convertido para o formato php.
*/
$data = json_decode(file_get_contents("php://input"));
#Verificar se os campos estão com dados.
if(!empty($data->id)){

    $estoque->id = $data->id;
    if($estoque->apagar()){
        header("HTTP/1.0 200");
        echo json_encode(array("mensagem"=>"estoque apagado com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possivel apagar oestoque."));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa passar todos os dados para apagar oestoque"));
}
?>