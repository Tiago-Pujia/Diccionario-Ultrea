<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/verify/verify-session-admin/verify-session.php';
if($verifySessionAdmin){
    exit('Error: se requiere permisos de admin');
}

if(!isset($_GET['id_word'])){
    echo 'Error: Falta de Datos';
    exit();
}

$id_word = $_GET['id_word'];

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = "UPDATE tbl_words SET DATE_DISABLED = now() WHERE ID_WORD = $id_word";
$response = $crud->exec($query);

echo $response;