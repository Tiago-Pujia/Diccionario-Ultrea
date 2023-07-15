<?php
if(!isset($_GET['id_word'])){
    echo 'Error: Falta de Datos';
    exit();
}

$id_word = $_GET['id_word'];

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = 
"SELECT 
    tbl_words.WORD,
    tbl_words.PRONUNCIATION,
    tbl_words.SIGNIFICANCE,
    tbl_type_word.NAME AS TYPE_WORD
FROM 
    tbl_words
LEFT JOIN
    tbl_type_word ON tbl_type_word.ID_TYPE = tbl_words.ID_TYPE_WORD
WHERE 
    ID_WORD = $id_word AND 
    ISNULL(tbl_words.DATE_DISABLED);";

$response = $crud->query($query)[0];
if(gettype($response) == 'array'){
    echo json_encode($response);
}

