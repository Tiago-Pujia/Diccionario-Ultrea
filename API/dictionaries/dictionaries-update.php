<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/verify/verify-session-admin/verify-session.php';
if($verifySessionAdmin){
    exit('Error: se requiere permisos de admin');
}

if(!isset($_GET['id_dictionary'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$id_dictionary = $_GET['id_dictionary'];
$dataChangue = [
    'NAME' => $getData('name'),
];

function getData($data){
    $filter = fn($arr) => strlen($arr) > 0;
    $data = array_filter($data,$filter);    
    $dataLenght = count($data) - 1;
    $set = '';
    
    foreach ($data as $key => $value) {
        if($value != 'null'){
            $set .= "$key = '$value'";
        } else {
            $set .= "$key = $value";
        }

        if(array_key_last($data) != $key){
            $set .= ',';
        }
    }

    return $set;
}

$query = 
"UPDATE 
    tbl_dictionaries 
SET " 
    . getData($dataChangue) . 
" WHERE 
    ID_DICTIONARY = $id_dictionary;";
$response = $crud->exec($query);

echo $response;