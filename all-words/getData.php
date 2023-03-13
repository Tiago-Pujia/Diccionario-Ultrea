<?php

include_once "../crud.php";

$page = isset($_GET['page']) ? $_GET['page'] : 0;
$pageSql = $page*25;

$query0 = "SELECT ID_WORD, WORD, PRONUNCIATION, SIGNIFICANSE FROM `tbl_words` ORDER BY WORD ASC LIMIT $pageSql,25;";
$rows = $crud->query($query0);

echo json_encode($rows);

?>