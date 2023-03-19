<?php
include_once 'log-in/verify-session.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diccionario Ultrea</title>

    <!-- Frameworks -->
        <!-- Bootstrap -->
        <link rel="stylesheet" href="/independences/bootstrap/bootstrap.min.css"/>
        <script src="/independences/bootstrap/bootstrap.bundle.min.js"></script>

        <!-- Bootstrap Icon -->
        <link rel="stylesheet" href="/independences/bootstrap-icons/font/bootstrap-icons.css"/>

    <!-- Scripts JS -->
    <script src="script.js" defer="true"></script>

    <!-- Styles CSS -->
    <style>
        td:nth-child(1){
            text-align:left;
        }

        @media (max-width: 576px) {
            thead{
                display: none;
            }        
        }
        
    </style>
</head>
<body class="bg-dark">
    <header class="container">
        <h1>a</h1>
    </header>
    <?php include_once $_SERVER['DOCUMENT_ROOT'] . '/screens/nav.html' ?>
    <main class="container">
        <div class="mb-5">
            <div class="form-floating">
                <input class="form-control" name="wordSeach" type="text" id="search" placeholder="Buscar Palabra a Modificar">
                <label for="search">Buscar palabra...</label>
            </div>
        </div>
        <div>
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Termino</th>
                            <th class="text-center text-primary">Definición</th>
                            <th class="text-center text-success">Actualizar</th>
                            <th class="text-center text-danger">Eliminar</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider text-center" id="tbody"></tbody>
                </table>
            </div>
        </div>
    </main>
    
    <div id="canvasConfig" class="offcanvas offcanvas-start text-bg-dark">
        <div id="canvasConfigHeader" class="offcanvas-header pb-0 d-none">
            <h3 class="offcanvas-title"></h3>
            <button class="btn-close btn-close-white border" data-bs-dismiss="offcanvas" style="border-color: #000 !important;"></button>
        </div>
        <div id="canvasConfigBody" class="offcanvas-body d-none">

        </div>
        
        <div class="text-center text-success" id="canvasConfigLoading">
            <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
        </div>

        <div id="canvasConfigConfirmQuery" class="text-success text-center d-none">
            <div class="border border-success rounded m-3">
                <div class="bi bi-check-lg w-100 h-100" style="width: 10rem; height: 10rem; font-size: 8rem;"></div>
            </div>
            <p>Petición Realizada</p>
            <button class="btn btn-success" data-bs-dismiss="offcanvas">Aceptar</button>
        </div>
    </div>
<!--     
    
 -->
<template id="templateCanvasConfigUpdate">
    <form class="canvasConfigForm">
        <hr class="text-white">
        <fieldset class="mb-4">
            <label class="form-label" for="configWordsUpdateWord">Palabra</label>
            <textarea class="form-control form-control-sm" name="word" id="configWordsUpdateWord"></textarea>
        </fieldset>
        <fieldset class="mb-4">
            <label class="form-label" for="configWordsUpdatePronunciation">Pronunciación</label>
            <textarea class="form-control form-control-sm" name="pronunciation" id="configWordsUpdatePronunciation"></textarea>
        </fieldset>
        <fieldset>
            <label class="form-label" for="configWordsUpdateSignificanse">Significado</label>
            <textarea class="form-control form-control-sm" name="significanse" id="configWordsUpdateSignificanse"></textarea>
        </fieldset>
        <hr class="text-white my-4">
        <button class="btn btn-success" type="submit">Actualizar</button>
    </form>
</template>

<template id="templateCanvasConfigDelete">
    <hr class="text-white">
    
    <p class="my-5">¿Estas seguro que desea deshabilitar el término "<spam class="canvasConfigWordDraw"></spam>"?</p>

    <hr class="text-white">

    <form class="canvasConfigForm">
        <button class="btn btn-danger" type="submit">Eliminar</button>
    </form>
</template>
</body>
</html>