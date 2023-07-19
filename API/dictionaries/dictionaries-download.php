<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/API/verify/verify-dictionary-used.php";
include_once $_SERVER['DOCUMENT_ROOT'] . '/API/index.php';

$id_dictionary = $getData('id_dictionary');

$query = <<<EOT
SELECT
    tbl_words.WORD, 
    tbl_words.PRONUNCIATION, 
    tbl_words.SIGNIFICANCE,
    tbl_type_word.NAME AS TYPE_WORD
FROM
    tbl_words
LEFT JOIN
    tbl_type_word ON 
        tbl_type_word.ID_TYPE = tbl_words.ID_TYPE_WORD
WHERE
    tbl_words.DATE_DISABLED IS NULL AND
    tbl_words.ID_DICTIONARY = $id_dictionary
ORDER BY tbl_words.WORD ASC;
EOT;
$tableWordDescription = $crud->query($query);

$query = <<<EOT
    SELECT
        COUNT(tbl_words.ID_WORD) AS WORDS_COUNT
    FROM 
        tbl_words
    WHERE
        DATE_DISABLED IS NULL AND ID_DICTIONARY = $id_dictionary
EOT;
$words_count = $crud->query($query)[0]['WORDS_COUNT'];

$query = <<<EOT
    SELECT
        NAME
    FROM 
    tbl_dictionaries
    WHERE
        ID_DICTIONARY = $id_dictionary
EOT;
$name_dictionary = $crud->query($query)[0]['NAME'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diccionario <?php echo $name_dictionary ?></title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <style><?php include_once $_SERVER['DOCUMENT_ROOT'] . "/independences/bootstrap/bootstrap.min.css"; ?></style>
        <script><?php include_once $_SERVER['DOCUMENT_ROOT'] . "/independences/bootstrap/bootstrap.bundle.min.js"; ?></script>

    <!-- styles CSS -->
    <style>
        main > * {
            max-width: 481.8pt !important;
        }

        .table-responsive{
            background-color: #fff;
            font-family: Arial;
            font-size: 12.0pt;
        }

        #table td{
            background-color: #fff;
            height: 1em !important;
            border: 1pt #000 solid;
            background-color: #fff !important;
        }

        #table tr:nth-child(1){
            border-bottom: 3px #000 solid;
        }
    </style>
</head>
<body class="bg-dark">
<div class="navbar bg-dark navbar-expand-md color-primary border-bottom border-primary mb-4 mb-md-5">
    <div class="container">
        <div class="navbar-brand m-0">
            <h1 class="text-primary text-wrap m-0">Diccionario <?php echo $name_dictionary ?></h1>
        </div>
        <div class="m-0">
            <a class="btn btn-primary" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/home/?id_dictionary=<?php echo $id_dictionary; ?>">📖 Entrada</a>
        </div>
    </div>
</div>
    <main class="container-fluid mb-5">

        <div class="row mb-3 align-item-center mx-auto" style="min-height:2.5rem;">
            <div class="col m-0 align-self-center">
                <p class="text-white fw-light m-0 ps-3">Resultados: <span class="showCount fw-bold"><?php echo $words_count; ?></span></p>
            </div>
            <div class="col m-0">
                <div class="text-end">
                    <button class="btn btn-outline-info" id="selectTable">Seleccionar Tabla</button>
                    <button class="btn btn-outline-secondary" id="pageDown"> ⮦ Bajar</button>
                </div>
            </div>
        </div>

        <div class="table-responsive mx-auto">
            <table class="table table-hover m-0 text-center" id="table">
                <tr class="fw-bold fw-strong">
                    <td>TÉRMINO</td>
                    <td>PRONUNCIACIÓN</td>
                    <td>CASTELLANO</td>
                    <td>CLASE</td>
                </tr>
                <?php
                    foreach ($tableWordDescription as $key) {
                        echo '<tr>';
                            echo '<td>' . $key['WORD'] . '</td>';
                            echo '<td>' . $key['PRONUNCIATION'] . '</td>';
                            echo '<td>' . $key['SIGNIFICANCE'] . '</td>';
                            echo '<td>' . $key['TYPE_WORD'] . '</td>';
                        echo '</tr>';
                    }
                ?>
            </table>
        </div>
        
        <div class="row mt-3 mx-auto" style="min-height:2.5rem;">
            <div class="col m-0">
                <div class="text-end">
                    <button class="d-inline btn btn-outline-secondary" id="pageUp"> ⮤ Subir</button>
                </div>
            </div>
        </div>
    </main>
    <script>
        const tagPageDown = document.querySelector("#pageDown");
        const tagPageUp = document.querySelector("#pageUp");
        const tagTable = document.querySelector("#table");
        const tagButtonSelectTable = document.querySelector("#selectTable");

        tagPageDown.addEventListener('click',()=>scrollTo(0,document.documentElement.scrollHeight));
        tagPageUp.addEventListener('click',()=>scrollTo(0,0));
        tagButtonSelectTable.addEventListener('click',()=>selectText(tagTable));

        const selectText = (element) => {
            let seleccion = getSelection();
            let rango = document.createRange();

            rango.selectNodeContents(element);
            seleccion.removeAllRanges();
            seleccion.addRange(rango);
        }
    </script>
</body>
</html>

