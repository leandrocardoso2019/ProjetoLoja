<?php
/*
Esse cabeçalho permite o acesso a listagem de endereco com diversas
origens.Por isso estamos usando o * para essa permissão que será para https,
http, file, ftp
*/
header("Access-Control-Allow-Origin:*");
/*
vamos definir qual será o formato de dados que o endereco irá enviar a api.
Este formato será dp tipo JSON(JavaScript On Natation)
*/
/*Abaixo estamos incluindo o arquivo database.php que possui o classe Database com o conexão com o banco de dados */
header("Content-Type: application/json;charset=utf-8");
include_once "../../config/database.php";
/* O arquivo endereco.php foi incluido para que a classe endereco fosse utilizada.
Vale lembrar que esta classe possui o CRUD para o endereco */
include_once "../../domain/endereco.php";
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
Instancia da classe endereco e, portanto, criação do objeto chamado $endereco.
Isso fará com que todas as funções que estão dentro da classe endereco sejam 
transferidas para o objeto $endereco.
Durante a instância foi passado como parametro a variavel $db que possui
a comunicação com o banco de dados e também a variavel conexao. Utilizado
para o uso dos comandos de CRUD
*/
$endereco = new Endereco($db);
/*
 A Variavel $stmt foi criada para guardar o retorno da consulta que esta na função listar. Dentro da função lista()
 temos uma consulta no formato sql que seleciona todos os endereco ("Select * from endereco")
 */
$stmt = $endereco->listar();
/*
Se a consulta retornar uma quantidade de linhas maior que 0(zero), então será 
construido um array com os dados dos usarios.
Casos contrario será exibida uma mensagem que não enderecos cadastrados
*/
if($stmt->rowCount() > 0){
    /*
    Para organizar os enderecos cadastrados em banco e exibi-los em tela, foi criado 
    um array com o nome de saida e assim guardar todos usarios.
    */
$endereco_array = array();
$endereco_array ["saida"] =array();
/*
A estrutura while (enquanto) realizando a busca e todos os enderecos
cadastrados até chegarao final da tabela e tras os dados para fetch
array organizar em formato de array.
Assim será mais facil de adicionar no array de enderecos para ser 
apresentado ao endereco
*/
while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
    /*
    O comando extract é capaz de separar de forma mais simples 
    os campos da tabela endereco.
    */
    extract($linha);
    /*
    Pegar um campo por vez do comando extract e adicionar em um
    array de itens, pois será assim que os enderecos serão tratados,
    um endereco por vez com seus respectivos dados.
    */
    $array_item = array(
        "id"=>$id,
        "logradouro"=>utf8_encode($logradouro),
        "numero"=>$numero,
        "complemento"=>$complemento,
        "bairro"=>utf8_encode($bairro),
        "cep"=>$cep
        
    );
    /*
    Pegar um item gerado pelo array_item e adicionar a saida,
    que também é um array.
    array_push é um comando em que você pode adicionar algo em um
    array. Assim estamos adicionando ao endereco_array[saida] um item 
    que é um endereco com seus respecyivos dados.

    */
    array_push($endereco_array["saida"],$array_item);
}
/*
O comando header(cabeçalho) responde via HTTP o status code 200 que 
representa sucesso na consulta de dados
*/
header("HTTP/1.0 200");
/*
Pegamos o array endereco_array que foi contruido em php com os dados dos enderecos e convertemos 
para o formato json para exibir ao cliente requisitanto
*/
echo json_encode($endereco_array);
}
else{
    /*
    O comando header(cabeçalho) responde ao cliente o status code 400(badrequest)
    caso não haja enderecos cadastrado no banco. Junto ao status code será exibido 
    a mensagem "mensagem: Não há enderecos cadastardos" que será mostrado por meio 
    do comando json_encode 
    */
    header("HTTP/1.0 400");

    echo json_encode(array("Mensagem"=>"Não há endereços cadastrados"));

}

?>