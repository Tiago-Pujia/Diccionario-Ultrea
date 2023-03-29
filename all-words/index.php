<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/API/verify/verify-dictionary-used.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista del Diccionario</title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/independences/bootstrap/bootstrap.min.css"/>
        <script src="/independences/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="/independences/bootstrap-icons/font/bootstrap-icons.css"/>
    
    <!-- scripts JS -->
    <script src="/screens/getQueryVariable.js"></script>
    <script defer="true" src="script.js"></script>

    <!-- styles CSS -->
    <style>
        td{
            height: 3rem !important;
        }

        main{
            border-bottom: calc(var(--bs-border-width) * 2) solid #fff !important;
        }

        @media (min-width: 576px){
            #pagination .pagination {
                justify-content: flex-end;
            }
        }
    </style>
</head>
<body class="bg-dark">
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/screens/header.html' ?>
    <script>
        fetch('/API/dictionaries/dictionaries-description.php?id_dictionary=' + idDictionary)
            .then((response)=>response.json())
            .then((response)=>{
                document.querySelector('h1').textContent = 'Palabras De ' + response.NAME;
                document.querySelector('title').textContent = 'Lista del Diccionario ' + response.NAME;
                tagLinkAllWords.classList.add('active');
            });
    </script>
    <main class="container mb-5">
        <div id="pagination" class="mb-3" style="min-height:2.5rem;">
            <div class="row align-items-center flex-column flex-sm-row gy-2 gy-sm-0">
                <div class="col m-0">
                    <p class="text-white fw-light m-0">Resultados: <span class="showCount fw-bold"></span></p>
                </div>
                <div class="col showPagination"></div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-dark d-none m-0" id="table">
                <thead class="table-group-divider">
                    <tr>
                        <th>#</th>
                        <th>TÉRMINO</th>
                        <th>PRONUNCIACIÓN</th>
                        <th>CASTELLANO</th>
                        <th>TIPO</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">

                </tbody>
            </table>
        </div>
        
        <div class="text-center text-primary" id="loading">
            <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
        </div>
    </main>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/screens/pagination.html'; ?>
</body>
</html>