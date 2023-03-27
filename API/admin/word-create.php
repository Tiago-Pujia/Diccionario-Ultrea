<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/verify/verify-session-admin/verify-session.php';
if($verifySessionAdmin){
    exit('Error: se requiere permisos de admin');
}

if(!isset($_GET['word'])){
    echo 'Error: Falta de Datos';
    exit();
}

if(!isset($_GET['id_dictionary'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$word = $getData('word');
$pronunciation = $getData('pronunciation');
$significance = $getData('significance');
$type = $getData('id_type_word','null');
$id_dictionary = $_GET['id_dictionary'];

$query = 
"INSERT INTO 
    tbl_words (ID_DICTIONARY,WORD,PRONUNCIATION,SIGNIFICANCE,ID_TYPE_WORD) 
VALUES 
    ($id_dictionary,'$word','$pronunciation','$significance',$type)";

$response = $crud->exec($query);

echo $response;
