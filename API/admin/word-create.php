<?php
if(!isset($_COOKIE['session']) || $_COOKIE['session'] != 'ak92nd9'){
    exit('Error: se requiere permisos de admin');
}

if(!isset($_GET['word'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';
$getData = fn($name,$default = '') => isset($_GET[$name]) ? $_GET[$name] : $default;

$word = $getData('word');
$pronunciation = $getData('pronunciation');
$significanse = $getData('significanse');

$query = "INSERT INTO $tableBD (WORD,PRONUNCIATION,SIGNIFICANSE) VALUES ('$word','$pronunciation','$significanse')";
$response = $crud->exec($query);

echo $response;
