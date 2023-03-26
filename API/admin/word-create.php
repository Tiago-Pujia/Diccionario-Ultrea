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
$type = $getData('id_type_word','null');

$query = "INSERT INTO tbl_words (WORD,PRONUNCIATION,SIGNIFICANCE,ID_TYPE_WORD) VALUES ('$word','$pronunciation','$significance',$type)";
$response = $crud->exec($query);

echo $response;
