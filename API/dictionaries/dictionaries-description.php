<?php
if(!isset($_GET['id_dictionary'])){
    echo 'Error: Falta de Datos';
    exit();
}

include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$id_dictionary = $_GET['id_dictionary'];
$query = 
"SELECT 
    tbl_dictionaries.ID_DICTIONARY, 
    tbl_dictionaries.NAME,
    COUNT(tbl_words.ID_WORD) AS WORDS_COUNT,
    tbl_dictionaries.DATE_CREATION 
FROM 
    tbl_dictionaries
LEFT JOIN
    tbl_words ON 
        tbl_words.ID_DICTIONARY = tbl_dictionaries.ID_DICTIONARY AND 
        tbl_words.DATE_DISABLED IS NULL
WHERE 
    tbl_dictionaries.ID_DICTIONARY = $id_dictionary
GROUP BY 
    tbl_dictionaries.ID_DICTIONARY;";

$response = $crud->query($query)[0];

echo json_encode($response);