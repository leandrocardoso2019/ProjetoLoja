<?php
/*
Esse cabeçalho permite o acesso a listagem de usuario com diversas
origens.Por isso estamos usando o * para essa permissão que será para https,
http, file, ftp
*/
header("Access-Control-Allow-Origin:*");
/*
vamos definir qual será o formato de dados que o usuario irá enviar a api.
Este formato será dp tipo JSON(JavaScript On Natation)
*/
header("Content-Type: application/json;charset=utf-8");
include_once "../../config/database.php";
include_once "../../domain/usuario.php";

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

?>