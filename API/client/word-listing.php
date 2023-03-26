<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$page = isset($_GET['page']) ? $_GET['page'] : 0;
$jumps = 25;
$pageSql = $page*$jumps;

$query = 
"SELECT 
    tbl_words.ID_WORD, 
    tbl_words.WORD, 
    tbl_words.PRONUNCIATION, 
    tbl_words.SIGNIFICANCE,
    tbl_type_word.NAME AS TYPE_WORD
FROM
    tbl_words
LEFT JOIN
    tbl_type_word ON tbl_type_word.ID_TYPE = tbl_words.ID_TYPE_WORD
WHERE 
    ISNULL(tbl_words.DATE_DISABLED) 
    ORDER BY tbl_words.WORD ASC 
    LIMIT $pageSql,$jumps;";

$rows = $crud->query($query);

echo json_encode($rows);