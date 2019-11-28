<?php
/*
Esse cabeçalho permite o acesso a listagem de pedido com diversas
origens.Por isso estamos usando o * para essa permissão que será para https,
http, file, ftp
*/
header("Access-Control-Allow-Origin:*");
/*
vamos definir qual será o formato de dados que o pedido irá enviar a api.
Este formato será dp tipo JSON(JavaScript On Natation)
*/
/*Abaixo estamos incluindo o arquivo database.php que possui o classe Database com o conexão com o banco de dados */
header("Content-Type: application/json;charset=utf-8");
include_once "../../config/database.php";
/* O arquivo pedido.php foi incluido para que a classe pedido fosse utilizada.
Vale lembrar que esta classe possui o CRUD para o pedido */
include_once "../../domain/pedido.php";
/*Criamos um objeto chamado $database. É uma instância do Database.
Quando usamos o termo new, estamos criando uma instância, ou seja, um objeto
da classe Database. Isso nos dará acesso a todos da classe Database. */
$database = new Database();
/*
Executamos a função getConnection que estabelece a conexão com o banco de 
dados. E retorna essa conexão realizada para a variavel $db
*/
$db = $database->getConnection();
/*
Instancia da classe pedido e, portanto, criação do objeto chamado $pedido.
Isso fará com que todas as funções que estão dentro da classe pedido sejam 
transferidas para o objeto $pedido.
Durante a instância foi passado como parametro a variavel $db que possui
a comunicação com o banco de dados e também a variavel conexao. Utilizado
para o uso dos comandos de CRUD
*/
$pedido = new Pedido($db);
/*
 A Variavel $stmt foi criada para guardar o retorno da consulta que esta na função listar. Dentro da função lista()
 temos uma consulta no formato sql que seleciona todos os pedido ("Select * from pedido")
 */
$stmt = $pedido->listar();
/*
Se a consulta retornar uma quantidade de linhas maior que 0(zero), então será 
construido um array com os dados dos usarios.
Casos contrario será exibida uma mensagem que não pedidos cadastrados
*/
if($stmt->rowCount() > 0){
    /*
    Para organizar os pedidos cadastrados em banco e exibi-los em tela, foi criado 
    um array com o nome de saida e assim guardar todos usarios.
    */
$pedido_array = array();
$pedido_array ["saida"] =array();
/*
A estrutura while (enquanto) realizando a busca e todos os pedidos
cadastrados até chegarao final da tabela e tras os dados para fetch
array organizar em formato de array.
Assim será mais facil de adicionar no array de pedidos para ser 
apresentado ao pedido
*/
while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
    /*
    O comando extract é capaz de separar de forma mais simples 
    os campos da tabela pedido.
    */
    extract($linha);
    /*
    Pegar um campo por vez do comando extract e adicionar em um
    array de itens, pois será assim que os pedidos serão tratados,
    um pedido por vez com seus respectivos dados.
    */
    $array_item = array(
        "id"=>$id,
        "id_cliente"=>$id_cliente,
        "data_pedido"=>$data_pedido
       
        
    );
    /*
    Pegar um item gerado pelo array_item e adicionar a saida,
    que também é um array.
    array_push é um comando em que você pode adicionar algo em um
    array. Assim estamos adicionando ao pedido_array[saida] um item 
    que é um pedido com seus respecyivos dados.

    */
    array_push($pedido_array["saida"],$array_item);
}
/*
O comando header(cabeçalho) responde via HTTP o status code 200 que 
representa sucesso na consulta de dados
*/
header("HTTP/1.0 200");
/*
Pegamos o array pedido_array que foi contruido em php com os dados dos pedidos e convertemos 
para o formato json para exibir ao cliente requisitanto
*/
echo json_encode($pedido_array);
}
else{
    /*
    O comando header(cabeçalho) responde ao cliente o status code 400(badrequest)
    caso não haja pedidos cadastrado no banco. Junto ao status code será exibido 
    a mensagem "mensagem: Não há pedidos cadastardos" que será mostrado por meio 
    do comando json_encode 
    */
    header("HTTP/1.0 400");

    echo json_encode(array("Mensagem"=>"Não há pedidos cadastrados"));

}

?>