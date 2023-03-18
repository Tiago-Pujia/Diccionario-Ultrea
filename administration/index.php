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
    </style>
</head>
<body>
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
                    <tbody class="table-group-divider text-center" id="tbody"></tbody>
                </table>
            </div>
        </div>
    </main>
    <div id="canvasConfigWordsUpdate" class="offcanvas offcanvas-start text-bg-dark">
        <div class="offcanvas-header pb-0 d-none">
            <h3 class="offcanvas-title text-success">Modificar Término<br>"<spam class="fst-italic"></spam>"</h3>
            <button class="btn-close btn-close-white border btnCloseCanvasUpdate" data-bs-dismiss="offcanvas" style="border-color: #000 !important;"></button>
        </div>
        <div class="offcanvas-body d-none">
            <hr class="text-white">
            <form id="formConfigWordsUpdate">
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
        </div>
        <div class="text-center text-success" id="loadingFormUpdate">
            <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
        </div>
        <div id="confirmQueryUpdate" class="text-success text-center d-none">
            <div class="border border-success rounded m-3">
                <div class="bi bi-check-lg w-100 h-100" style="width: 10rem; height: 10rem; font-size: 8rem;"></div>
            </div>
            <p class="">Termino Modificado Correctamente</p>
            <button class="btn btn-success btnCloseCanvasUpdate" data-bs-dismiss="offcanvas">Aceptar</button>
        </div>
    </div>

    <div id="canvasConfigWordsDelete" class="offcanvas offcanvas-start text-bg-dark">
        <div class="offcanvas-header pb-0">
            <h3 class="offcanvas-title text-danger">Eliminar Concepto</h3>
            <button class="btn-close btn-close-white border" data-bs-dismiss="offcanvas" style="border-color: #dc3545 !important;"></button>
        </div>
        <div class="offcanvas-body">
            <hr class="text-white">
            <p class="my-5">¿Estas seguro que desea deshabilitar el término "<spam></spam>"?</p>
            <hr class="text-white">
            <form id="formConfigWordsDelete">
                <button class="btn btn-danger" type="submit">Eliminar</button>
            </form>
        </div>
        
        <div class="text-center text-primary d-none" id="loadingFormDelete">
            <div class="spinner-border" style="width: 10rem; height: 10rem; margin: 7rem 0;"></div>
        </div>

        <div id="confirmQueryDelete" class="text-success text-center d-none">
            <div class="border border-success rounded m-3">
                <div class="bi bi-check-lg w-100 h-100" style="width: 10rem; height: 10rem; font-size: 8rem;"></div>
            </div>
            <p class="">Termino Eliminado Correctamente</p>
            <button class="btn btn-success" data-bs-dismiss="offcanvas">Aceptar</button>
        </div>
    </div>
</body>
</html>