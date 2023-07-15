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
$query = 
"UPDATE 
    tbl_dictionaries 
SET 
    DATE_DISABLED = now()
WHERE 
    ID_DICTIONARY = $id_dictionary";
echo $crud->exec($query);