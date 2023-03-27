<?php
if(!isset($_GET['id_type_word'])){
    echo 'Error: Falta de Datos';
    exit();
}

$id_type_word = $_GET['id_type_word'];

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = 
"SELECT 
    NAME
FROM 
    tbl_type_word
WHERE 
    ID_WORD = $id_type_word;";

$response = $crud->query($query)[0];
echo json_encode($response);

