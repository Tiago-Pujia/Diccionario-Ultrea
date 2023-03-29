<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$query = 
"SELECT 
    tbl_dictionaries.ID_DICTIONARY, 
    tbl_dictionaries.NAME,
    COUNT(tbl_words.ID_WORD) AS WORDS_COUNT,
    tbl_dictionaries.DATE_DISABLED 
FROM 
    tbl_dictionaries
LEFT JOIN
    tbl_words USING(ID_DICTIONARY)
WHERE 
    tbl_dictionaries.DATE_DISABLED IS NOT NULL AND
    tbl_words.DATE_DISABLED IS NULL
GROUP BY 
    tbl_dictionaries.ID_DICTIONARY";

$response = $crud->query($query);

echo json_encode($response);