<?php
$getData = fn($name,$default = '') => isset($_GET[$name]) ? $_GET[$name] : $default;
include_once '../crud.php';

$id_word = $getData('id_word');

if(is_numeric($id_word)) {
    $query = "SELECT WORD,PRONUNCIATION,SIGNIFICANSE FROM tbl_words WHERE ID_WORD = $id_word;";
    $response = $crud->query($query)[0];
    echo json_encode($response);
    exit();
}

$search_words = $getData('words_search');
$search_options = $getData('options_search');
$field = '';

switch ($search_options) {
    default;
    case 'ultrea':
        $field = 'WORD';
        break;

    case 'pronunciation':
        $field = 'PRONUNCIATION';
        break;

    case 'significance':
        $field = 'SIGNIFICANSE';
        break;
}

$query = "SELECT ID_WORD, $field AS WORD FROM tbl_words WHERE $field LIKE '$search_words%';";
$response = $crud->query($query);

echo json_encode($response);
?>