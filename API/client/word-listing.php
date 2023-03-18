<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$page = isset($_GET['page']) ? $_GET['page'] : 0;
$jumps = 25;
$pageSql = $page*$jumps;

$query0 = "SELECT ID_WORD, WORD, PRONUNCIATION, SIGNIFICANSE FROM $tableBD WHERE ISNULL(DATE_DISABLED) ORDER BY WORD ASC LIMIT $pageSql,$jumps;";
$rows = $crud->query($query0);

echo json_encode($rows);