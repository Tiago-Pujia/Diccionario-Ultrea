<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

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
    tbl_dictionaries.DATE_DISABLED IS NULL
GROUP BY 
    tbl_dictionaries.ID_DICTIONARY";

$response = $crud->query($query);

echo json_encode($response);