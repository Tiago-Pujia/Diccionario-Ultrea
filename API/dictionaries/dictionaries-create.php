<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/verify/verify-session-admin/verify-session.php';
if($verifySessionAdmin){
    exit('Error: se requiere permisos de admin');
}

if(!isset($_GET['name'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$name = $_GET['name'];
echo $query = 
"INSERT INTO 
    tbl_dictionaries (NAME) 
VALUES 
    ('$name');";
$response = $crud->exec($query);

echo $response;