<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/admin/verify-session.php';
if($verifySession){
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
$significance = $getData('significance');

$query = "INSERT INTO tbl_words (WORD,PRONUNCIATION,SIGNIFICANCE) VALUES ('$word','$pronunciation','$significance')";
$response = $crud->exec($query);

echo $response;
