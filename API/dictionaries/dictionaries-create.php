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

$name = $getData('name');

$query = <<<EOT
INSERT INTO 
    tbl_dictionaries (NAME) 
VALUES 
    ('$name');
EOT;

echo $crud->exec($query);